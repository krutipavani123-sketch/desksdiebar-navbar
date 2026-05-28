<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\TeamReport;

class LeaderMonitorPerformanceController extends Controller
{


    public function index()
    {
        $leader = auth()->user();

        $reports = TeamReport::whereHas('team', function ($q) use ($leader) {

            $q->where('leader_id', $leader->id);
        })->latest()->get();

        return view('monitor', compact('reports'));
    }

    // public function index()
    // {
    //     $reports = TeamReport::latest()->get();
    //     return view('monitor', compact('reports'));
    // }
    public function teamreport()
    {
        return view('teamreport');
    }
}
