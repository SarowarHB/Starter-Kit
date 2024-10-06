<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Enum;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function dashboard()
    {
        $employee = User::select('is_active', DB::raw('count(*) as total'))->where('user_type', Enum::USER_TYPE_ADMIN)->groupBy('is_active')->pluck('total', 'is_active')->toArray();

        $deletedEmployee = User::where('user_type', Enum::USER_TYPE_ADMIN)->onlyTrashed()->count();

        $member = User::select('is_active', DB::raw('count(*) as total'))->where('user_type', Enum::USER_TYPE_MEMBER)->groupBy('is_active')->pluck('total', 'is_active')->toArray();
        $deletedMember = User::where('user_type', Enum::USER_TYPE_MEMBER)->onlyTrashed()->count();

        $ticket = Ticket::select('status', DB::raw('count(*) as total'))->groupBy('status')->pluck('total', 'status')->toArray();

        return view('admin.pages.home.dashboard', compact(
            'employee', 'deletedEmployee', 'member', 'deletedMember', 'ticket'
        ));
    }
}
