<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Role;
use App\Models\User;
use App\Models\Team;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    // function clearDashboardCache()
    // {
    //     Cache::forget('dashboard_stats');
    //     Cache::forget('admindashboard_stats');
    // }
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('superadmin')) {

            //key ,time ,function            5 min
            $data = Cache::remember('dashboard_stats', 300,  function () {
                return [
                    'totaluser' => User::count(),
                    'totalrole' => Role::count(),
                    'totalteam' => Team::count(),
                    'totalpermission' => Permission::count(),
                    'totalticket' => Ticket::count(),
                ];
            });

            $ticketchart = Ticket::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $categories = $ticketchart->keys();   // use for x label

            $values = $ticketchart->values();    // use for y label

            $series = [
                'type' => 'column',
                'name' => 'Tickets',
                'data' => $values
            ];


            $agentdata = User::role('support_agent')
                ->withcount('assignedticket')
                ->get();

            $pie = [];

            foreach ($agentdata as $agent) {
                $pie[] = [
                    'name' => $agent->name,
                    'y' => $agent->assignedticket_count
                ];
            }
            return view('dashboards.superadmin', array_merge(
                $data,
                [
                    'values' => $values,
                    'categories' => $categories,
                    'series' => $series,
                    'pie' => $pie,
                ]
            ));
        }
        // $totaluser = User::count();
        // $totalrole = Role::count();
        // $totalteam = Team::count();
        // $totalpermission = Permission::count();
        // $totalticket = Ticket::count();
        // return view('dashboards.superadmin', compact(
        //     'totaluser',
        //     'totalrole',
        //     'totalteam',
        //     'totalpermission',
        //     'totalticket'
        // ));


        if ($user->hasRole('admin')) {

            $admindata = Cache::remember('admindashboard_stats', 300, function () {
                return [

                    'totalteam' => Team::count(),
                    'totalticket' => Ticket::count(),
                    'agents' => User::role('support_agent')->count(),
                    'totalopenticket' => Ticket::where('status', 'Open')->count(),
                    'totalcloseticket' => Ticket::where('status', 'Closed')->count(),
                    'totalpendingticket' => Ticket::where('status', 'Pending')->count(),
                    'totalprogressticket' => Ticket::where('status', 'In Progress')->count(),
                    'totalreopenticket' => Ticket::where('status', 'ReOpened')->count(),
                ];
            });

            $ticketchart = Ticket::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            $categories = $ticketchart->keys();   // use for x label

            $values = $ticketchart->values();    // use for y label

            $series = [
                'type' => 'column',
                'name' => 'Tickets',
                'data' => $values
            ];


            $agentdata = User::role('support_agent')
                ->withcount('assignedticket')
                ->get();

            $pie = [];

            foreach ($agentdata as $agent) {
                $pie[] = [
                    'name' => $agent->name,
                    'y' => $agent->assignedticket_count
                ];
            }
            return view('dashboards.admin', array_merge(
                $admindata,
                [
                    'values' => $values,
                    'categories' => $categories,
                    'series' => $series,
                    'pie' => $pie,
                ]
            ));
        }
        // $totalteam = Team::count();
        // $totalticket = Ticket::count();
        // $agents = User::role('support_agent')->count();
        // $totalopenticket = Ticket::where('status', 'Open')->count();
        // $totalcloseticket = Ticket::where('status', 'Closed')->count();
        // $totalpendingticket = Ticket::where('status', 'Pending')->count();
        // $totalprogressticket = Ticket::where('status', 'In Progress')->count();
        // $totalreopenticket = Ticket::where('status', 'ReOpened')->count();
        // return view('dashboards.admin', compact(
        //     'totalteam',
        //     'totalticket',
        //     'agents',
        //     'totalopenticket',
        //     'totalcloseticket',
        //     'totalpendingticket',
        //     'totalprogressticket',
        //     'totalreopenticket'

        // ));


        if ($user->hasRole('team_leader')) {

            // $team = Team::where('leader_id', auth()->id())->pluck('id');

            $leaderdata = Cache::remember('leaderdashboard_stats', 300, function () {
                $team = Team::where('leader_id', auth()->id())->pluck('id');

                return [
                    // 'team' => Team::where('leader_id', auth()->id())->pluck('id'),

                    'myticket' => Ticket::whereIn('assigned_team_id', $team)->count(),

                    'openticket' => Ticket::WhereIn('assigned_team_id', $team)->where('status', 'Open')
                        ->count(),


                    'agents' => User::role('support_agent')
                        ->whereHas('teams', function ($q) use ($team) {
                            $q->whereIn('teams.id', $team);  //check user team id in $team 
                        })
                        ->count(),

                ];
            });
            return view('dashboards.teamleader', $leaderdata);
            // return view('dashboards.teamleader', compact('myticket', 'openticket', 'agents'));
        }

        if ($user->hasRole('support_agent')) {

            $agentdata = Cache::remember('agentdashboard_stats', 300, function () {
                return [

                    'assignticket' => Ticket::where('assigned_agent_id', auth()->id())->count(),
                    'resolved' => Ticket::where('assigned_agent_id', auth()->id())
                        ->where('status', 'Closed')
                        ->count(),

                    'totalpendingticket' => Ticket::where('assigned_agent_id', auth()->id())
                        ->where('status', 'Pending')
                        ->count(),


                ];
            });
            return view('dashboards.agent', $agentdata);
        }

        if ($user->hasRole('customer')) {

            $customerdata = Cache::remember('customerdashboard_tasks', 300, function () {
                return [
                    //$user= User::where('id', auth()->id())->pluck('id');
                    'ticket' => Ticket::where('customer_id', auth()->id())->count(),
                    'openticket' => Ticket::where('customer_id', auth()->id())
                        ->where('status', 'Open')
                        ->count(),
                    'resolved' => Ticket::where('customer_id', auth()->id())
                        ->where('status', 'Closed')
                        ->count(),

                    'overdue' => Ticket::where('customer_id', auth()->id())
                        ->where('status', 'Overdue')
                        ->count() ?? 0,

                ];
            });
            return view(
                'dashboards.customer',
                $customerdata
            );
        }
    }
}
