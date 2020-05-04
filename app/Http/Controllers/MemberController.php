<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Arr;
use Image;
use Carbon\Carbon;
use App\Entities\Member;
use App\Entities\Salutation;
use App\Entities\PrayerRequest;
use App\Entities\MemberComment;
use App\Entities\ServiceInterest;
use App\Entities\MemberGroup;
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequestForm;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->date_filter)) {
            $parts = explode(' - ', $request->date_filter);
            $date_from = $parts[0];
            $date_to = $parts[1];
        } else {
            $carbon_date_from = Carbon::now()->subDays(6);
            $date_from = $carbon_date_from->toDateString();
            $carbon_date_to = Carbon::now();
            $date_to = $carbon_date_to->toDateString();
        }

        if($request->has('q')) {
            $modelRequest = Member::orderBy('created_at', 'desc')->where('first_name', 'like', '%'.$request->get('q').'%')
                ->orWhere('middle_name', 'like', '%'.$request->get('q').'%')
                ->orWhere('surname', 'like', '%'.$request->get('q').'%');
            $members = authRole($modelRequest, auth()->user());
            
            return view('member.index', compact('members'));
        }

        $model = Member::with(['comments', 'serviceInterest', 'prayers'])->orderBy('created_at', 'desc')
            ->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);

        $members = authRole($model, auth()->user());

        return view('member.index', compact('members'));
    }

    public function create()
    {
        $flag = false;

        $member_groups = [];

        $modelMemberGroup = MemberGroup::orderBy('name', 'asc');
        foreach(authRole($modelMemberGroup, auth()->user()) as $m) {
            $member_groups[$m->id] = Str::upper($m->name);
        }
        
        $salutations = Salutation::pluck('short_code', 'id')->all();
        $service_interests = ServiceInterest::pluck('name', 'id')->all(); 

        return view('member.create', compact('salutations', 'service_interests', 'flag', 'member_groups'));
    }

    public function store(MemberRequestForm $request)
    {
        $input = $request->all();
        $input['code'] = Member::code();
        $input['birthday'] = date('Y-m-d h:m:s', strtotime($input['birthday']));
        $input['organization_id'] = auth()->user()->organization_id;

        if($files = $request->file('photo')) {
            $imageUpload = Image::make($files);
            $imagePath = public_path('img/members/');
            $imageUpload->resize(220,200);
            $imageUpload->save($imagePath.time().'-'.Str::slug(Member::getFullname($input)).'.'.$files->getClientOriginalExtension());

            $input['photo'] = 'img/members/'.time().'-'.Str::slug(Member::getFullname($input)).'.'.$files->getClientOriginalExtension();
        }

        if(request()->has('first_time_visitor')) {
            $input['first_time_visitor'] = Member::checkbox($input['first_time_visitor']);
        }

        if(request()->has('returning_visitor')) {
            $input['returning_visitor'] = Member::checkbox($input['returning_visitor']);
        }

        if(request()->has('new_resident')) {
            $input['new_resident'] = Member::checkbox($input['new_resident']);
        }
        
        if(request()->has('membership_interest')) {
            $input['membership_interest'] = Member::checkbox($input['membership_interest']);
        }

        if(request()->has('like_visited')) {
            $input['like_visited'] = Member::checkbox($input['like_visited']);
        }

        if(request()->has('save_before')) {
            $input['save_before'] = Member::checkbox($input['save_before']);
        }

        if(request()->has('baptized')) {
            $input['baptized'] = Member::checkbox($input['baptized']);
        }

        if(request()->has('workforce_interest')) {
            $input['workforce_interest'] = Member::checkbox($input['workforce_interest']);
        }

        DB::transaction(function() use($input) {
            $memberBasicData = Arr::except($input, ['comment', 'prayer_point']);
            $member = Member::create($memberBasicData);

            $prayers = Arr::only($input, ['prayer_point']);  
            
            if($prayers) {
                foreach ($prayers as $prequests) {
                    foreach ($prequests as $key => $value) {
                        if(!is_null($value) || !empty($value)) {
                            $prayer_request = new PrayerRequest;
                            $prayer_request->member_id = $member['id'];
                            $prayer_request->organization_id = auth()->user()->organization_id;
                            $prayer_request->prayer_point = $value;
                            $prayer_request->save();
                        }
                    }
                }
            }
            
            if(!is_null($input['comment']) || !empty($input['comment'])) {
                $commentData = Arr::only($input, 'comment');
                $data = Arr::add($commentData, 'member_id', $member['id'], 'organization_id', auth()->user()->organization_id);
                MemberComment::create($data);
            }
        });

        return redirect()->route('comrades.index');
    }

    public function show($slug)
    {
        $model = Member::with(['comments', 'serviceInterest', 'prayers']);
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);

        return view('member.detail', compact('member'));
    }

    public function edit($slug)
    {
        $flag = true;
        $model = Member::with(['comments', 'serviceInterest', 'prayers']);
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);

        $salutations = Salutation::pluck('short_code', 'id')->all();
        $service_interests = ServiceInterest::pluck('name', 'id')->all(); 

        return view('member.edit', compact('salutations', 'service_interests', 'member', 'flag'));
    }

    public function update(Request $request, $slug)
    {
        $input = $request->all();

        $model = Member::orderBy('created_at');
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);

        $input['birthday'] = date('Y-m-d h:m:s', strtotime($input['birthday']));
        $input['organization_id'] = auth()->user()->organization_id;

        if($files = $request->file('photo')) {
            $imageUpload = Image::make($files);
            $imagePath = public_path('img/members/');
            $imageUpload->resize(120,100);
            $imageUpload->save($imagePath.time().'-'.Str::slug(Member::getFullname($input)).'.'.$files->getClientOriginalExtension());

            $input['photo'] = 'img/members/'.time().'-'.Str::slug(Member::getFullname($input)).'.'.$files->getClientOriginalExtension();
        }
        else {
            $input = Arr::except($input, ['photo']);
        }

        if(request()->has('first_time_visitor')) {
            $input['first_time_visitor'] = Member::checkbox($input['first_time_visitor']);
        }

        if(request()->has('returning_visitor')) {
            $input['returning_visitor'] = Member::checkbox($input['returning_visitor']);
        }

        if(request()->has('new_resident')) {
            $input['new_resident'] = Member::checkbox($input['new_resident']);
        }
        
        if(request()->has('membership_interest')) {
            $input['membership_interest'] = Member::checkbox($input['membership_interest']);
        }

        if(request()->has('like_visited')) {
            $input['like_visited'] = Member::checkbox($input['like_visited']);
        }

        if(request()->has('save_before')) {
            $input['save_before'] = Member::checkbox($input['save_before']);
        }

        if(request()->has('baptized')) {
            $input['baptized'] = Member::checkbox($input['baptized']);
        }

        if(request()->has('workforce_interest')) {
            $input['workforce_interest'] = Member::checkbox($input['workforce_interest']);
        }

        DB::transaction(function() use($input, $member) {
            $member->update($input);
        });

        return redirect()->route('comrades.index');
    }

    public function destroy($slug)
    {
        $model = Member::orderBy('created_at', 'desc');
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);
      
        $member->delete();

        return redirect()->route('comrades.index');
    }

    public function restoreMember($slug)
    {
        $model = Member::orderBy('created_at', 'desc')->withTrashed();
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);

        $member->restore();

        return redirect()->route('comrades.show', $member['slug']);
    }

    public function retrievArchived(Request $request)
    {
        if (isset($request->date_filter)) {
            $parts = explode(' - ', $request->date_filter);
            $date_from = $parts[0];
            $date_to = $parts[1];
        } else {
            $carbon_date_from = Carbon::now()->subDays(6);
            $date_from = $carbon_date_from->toDateString();
            $carbon_date_to = Carbon::now();
            $date_to = $carbon_date_to->toDateString();
        }

        $model = Member::with(['comments', 'serviceInterest', 'prayers'])->orderBy('created_at', 'desc')->onlyTrashed()->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $members = authRole($model, auth()->user());

        return view('report.member.archive', compact('members'));
    }
}
