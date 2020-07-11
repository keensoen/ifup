<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\Member;
use App\Entities\MemberComment;
use Illuminate\Http\Request;

class MemberCommentController extends Controller
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

        $model = MemberComment::orderBy('created_at', 'asc')->whereDate('created_at', '>=', $date_from)->whereDate('created_at', '<=', $date_to);
        $comments = authRole($model, auth()->user());
        
        return view('member.comment', compact('comments'));
    }
}
