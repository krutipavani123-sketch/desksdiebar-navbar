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

        if ($user->hasRole('superadmin')) {
            return view('dashboards.superadmin');
        }

        if ($user->hasRole('admin')) {
            return view('dashboards.admin');
        }

        if ($user->hasRole('team_leader')) {
            return view('dashboards.teamleader');
        }

        if ($user->hasRole('support_agent')) {
            return view('dashboards.agent');
        }

        return view('dashboards.customer');
    }
}
