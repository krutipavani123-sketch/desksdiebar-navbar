<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

use App\Models\User;
class DashboardController extends Controller
{
     public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('super_admin')) {
            return view('dashboard.superadmin');
        }

        if ($user->hasRole('admin')) {
            return view('dashboard.admin');
        }

        if ($user->hasRole('team_leader')) {
            return view('dashboard.teamleader');
        }

        if ($user->hasRole('support_agent')) {
            return view('dashboard.agent');
        }

        if ($user->hasRole('customer')) {
            return view('dashboard.customer');
        }

        abort(403);
    }
}