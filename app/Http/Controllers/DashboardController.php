<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {

            $totaluser = User::count();
            $totalrole = Role::count();
            $totalteam = Team::count();
            $totalpermission = Permission::count();
            $totalticket = Ticket::count();
            return view('dashboards.superadmin', compact(
                'totaluser',
                'totalrole',
                'totalteam',
                'totalpermission',
                'totalticket'
            ));
        }

        if ($user->hasRole('admin')) {


            $totalteam = Team::count();
            $totalticket = Ticket::count();
            $agents = User::role('support_agent')->count();
            $totalopenticket = Ticket::where('status', 'Open')->count();
            $totalcloseticket = Ticket::where('status', 'Closed')->count();
            $totalpendingticket = Ticket::where('status', 'Pending')->count();
            $totalprogressticket = Ticket::where('status', 'In Progress')->count();
            $totalreopenticket = Ticket::where('status', 'ReOpened')->count();
            return view('dashboards.admin', compact(
                'totalteam',
                'totalticket',
                'agents',
                'totalopenticket',
                'totalcloseticket',
                'totalpendingticket',
                'totalprogressticket',
                'totalreopenticket'

            ));
        }

        if ($user->hasRole('team_leader')) {


            $team = Team::where('leader_id', auth()->id())->pluck('id');

            $myticket = Ticket::whereIn('assigned_team_id', $team)->count();
            $openticket = Ticket::WhereIn('assigned_team_id', $team)->where('status', 'Open')
                ->count();


            $agents = User::role('support_agent')
                ->whereHas('teams', function ($q) use ($team) {
                    $q->whereIn('teams.id', $team);  //check user team id in $team 
                })
                ->count();

            return view('dashboards.teamleader', compact('myticket', 'openticket', 'agents'));
        }

        if ($user->hasRole('support_agent')) {
            $assignticket = Ticket::where('assigned_agent_id', auth()->id())->count();
            $resolved = Ticket::where('assigned_agent_id', auth()->id())
                ->where('status', 'Closed')
                ->count();

            $totalpendingticket = Ticket::where('assigned_agent_id', auth()->id())
                ->where('status', 'Pending')
                ->count();


            return view('dashboards.agent', compact(
                'assignticket',
                'resolved',
                'totalpendingticket',
            ));
        }

        if ($user->hasRole('customer')) {

            //$user= User::where('id', auth()->id())->pluck('id');
            $ticket = Ticket::where('customer_id', auth()->id())->count();
            $openticket = Ticket::where('customer_id', auth()->id())
                ->where('status', 'Open')
                ->count();
            $resolved = Ticket::where('customer_id', auth()->id())
                ->where('status', 'Closed')
                ->count();

            return view(
                'dashboards.customer',
                compact(
                    'ticket',
                    'openticket',
                    'resolved'
                )
            );
        }
    }
}
