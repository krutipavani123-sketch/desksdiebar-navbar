<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class ReportController extends Controller
{

    public function showreport()
    {
        return view('reportview');
    }

    public function reports()
    {
        $reports = Report::latest()->get();
        return view('reports', compact('reports'));
    }
}







 // $ticketsummary = [
        //     'total' => Ticket::count(),
        //     'open' => Ticket::where('status', 'Open')->count(),
        //     'close' => Ticket::where('status', 'Closed')->count(),
        //     'pending' => Ticket::where('status', 'Pending')->count(),

        // ];

        // $agents = User::role('support_agent')
        //     ->withcount([
        //         'tickets as totaltickets',
        //         'tickets as closetickets' =>
        //         function ($q) {
        //             $q->where('status', 'Closed');
        //         }
        //     ])->get();

        // $slabreached = Ticket::where('status', '!=', 'Closed')
        //     ->whereNotNull('sla_deadline')
        //     ->where('sla_deadline', '<', now())
        //     ->count();

        // $customers = User::role('customer')
        //     ->withcount('tickets')->get();

        // return view('reports', compact(
        //     'ticketsummary',
        //     'agents',
        //     'slabreached',
        //     'customers'
        // ));
