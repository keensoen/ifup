<?php

namespace App\Http\Controllers;

use DB;
use Str;
use Arr;
use Image;
use App\User;
use Carbon\Carbon;
use App\Entities\Member;
use App\Entities\Salutation;
use App\Entities\PrayerRequest;
use App\Entities\MemberComment;
use App\Entities\ServiceInterest;
use App\Entities\MemberGroup;
use Illuminate\Http\Request;
use App\Http\Requests\MemberRequestForm;
use Illuminate\Support\Facades\Hash;
use App\Entities\MemberReport;
use App\Imports\MembersImport;
use Illuminate\Support\Facades\Storage;
use Excel;

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
            $modelRequest = Member::orderBy('members.code', 'desc')->where('first_name', 'like', '%'.$request->get('q').'%')
                ->orWhere('middle_name', 'like', '%'.$request->get('q').'%')
                ->orWhere('surname', 'like', '%'.$request->get('q').'%');
            $members = authRole($modelRequest, auth()->user());
            
            return view('member.index', compact('members'));
        }

        $model = Member::with(['comments', 'serviceInterest', 'prayers'])->orderBy('members.code', 'desc')
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

    public function store(Request $request)
    {
        $input = $request->all();
        //dd($request->all());
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
                $data = Arr::add($commentData, 'member_id', $member['id']);
                $comData = Arr::add($data, 'organization_id', auth()->user()->organization_id);
                MemberComment::create($comData);
            }

            if($input['login_details'] == '1' && $member) {
                $user = new User();
                $user->member_id = $member->id;
                $user->organization_id = $member->organization_id;
                $user->username = $member->code;
                $user->email = $member->email ? $member->email : '';
                $user->password = bcrypt($member->tel);
                $user->photo = $member->photo;
                $user->save();

                if($user) {
                    $message = 'Good day Sir/Ma. Download ifup app via play store or apple store. Your login details is: username: '.$member->code.' Password: 123456. God bless you.';

                    sendRegistrationSMS($member->id, $message);
                }

            }
        });

        return redirect()->route('members.index');
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


        $member_groups = [];

        $modelMemberGroup = MemberGroup::orderBy('name', 'asc');
        foreach(authRole($modelMemberGroup, auth()->user()) as $m) {
            $member_groups[$m->id] = Str::upper($m->name);
        }

        $model = Member::with(['comments', 'serviceInterest', 'prayers', 'salute']);
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);

        $salutations = Salutation::pluck('short_code', 'id')->all();
        $service_interests = ServiceInterest::pluck('name', 'id')->all(); 

        return view('member.edit', compact('salutations', 'service_interests', 'member', 'member_groups', 'flag'));
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

        // if(request()->has('address')) {

        //     // $latLong = Member::getLatLong($request->address);
        //     // dd($latLong);
        //     $input['lat'] = $latLong['lat']? $latLong['lat']:'NULL';
        //     $input['lng'] = $latLong['lng']? $latLong['lng']:'NULL';
        // }

        DB::transaction(function() use($input, $member) {
            $member->update($input);
        });

        return redirect()->route('members.index');
    }

    public function destroy($slug)
    {
        $model = Member::orderBy('created_at', 'desc');
        $member = authRoleFindWithSlug($model, auth()->user(), $slug);
      
        $member->delete();

        return redirect()->route('members.index');
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

    public function postVisitFeedback(Request $request)
    {
        $this->validate($request, [
            'comment'   => ['required', 'min:0', 'string'],
        ]);

        $member = Member::findOrFail($request['member_id']);
        
        DB::transaction(function() use($request) {
            $input = $request->all();
            $input['organization_id'] = auth()->user()->organization_id;
            $input['added_by'] = auth()->user()->id;

            MemberReport::create($input);
        });

        return redirect()->route('comrades.show', $member['slug']);
    }

    public function import(Request $request) 
    {
        // $this->validate($request, [
        //     'import_file' => 'required|mimes:xls,xlsx,csv'
        // ]);

        if(request()->has('import_file')){

            $import = Excel::import(new MembersImport, request()->file('import_file'));

            if ($import) {
                return redirect()->route('members.index')->with('success', 'Members upload successfully!');
            }
        }

        return redirect()->route('members.index')->with('error', 'An Error has occured!');
    }

    public function heatMap()
    {
        $members = Member::where('lat', '<>', null)->where('lng', '<>', null)->whereOrganizationId(auth()->user()->organization_id)->select('first_name', 'middle_name', 'surname', 'address','lat', 'lng')->get();
        Storage::disk('public')->put('members.json', response()->json($members));
        return view('member.heat_map', compact('members'));
    }

    public function heatMapJson()
    {
        $members = Member::where('lat', '<>', null)->where('lng', '<>', null)->select('lat', 'lng')->get();

        return response()->json(['results' => $members], 200);
    }
}
