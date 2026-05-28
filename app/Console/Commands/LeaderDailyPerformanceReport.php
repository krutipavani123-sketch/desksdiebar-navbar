<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Team;
use App\Models\TeamReport;
use Illuminate\Support\Facades\Storage;

class LeaderDailyPerformanceReport extends Command
{
    protected $signature = 'app:leader-daily-performance-report';

    protected $description = 'Generate Team Leader Daily Performance Report';

    public function handle()
    {
        $leaders = User::role('team_leader')->get();

        foreach ($leaders as $leader) {

            // Get leader teams
            $teams = Team::where('leader_id', $leader->id)->get();

            foreach ($teams as $team) {

                // =====================================
                // TEAM OVERVIEW
                // =====================================

                $teamOverview = [

                    'team_name' => $team->teamName,

                    'leader_name' => $leader->name,

                    'total_agents' => $team->users()
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'support_agent');
                        })
                        ->count(),
                ];



                $ticketStatus = [

                    'total' => Ticket::where('assigned_team_id', $team->id)->count(),

                    'open' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Open')
                        ->count(),

                    'closed' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Closed')
                        ->count(),

                    'pending' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Pending')
                        ->count(),

                    'overdue' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Overdue')
                        ->count(),
                ];



                $slaData = [

                    'sla_breached' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', '!=', 'Closed')
                        ->whereNotNull('sla_deadline')
                        ->where('sla_deadline', '<', now())
                        ->count(),

                    'sla_completed' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Closed')
                        ->count(),
                ];


                // $performanceSummary = [

                //     'resolution_rate' =>
                //     $ticketStatus['total'] > 0
                //         ? round(($ticketStatus['closed'] / $ticketStatus['total']) * 100, 2)
                //         : 0,

                //     'pending_rate' =>
                //     $ticketStatus['total'] > 0
                //         ? round(($ticketStatus['pending'] / $ticketStatus['total']) * 100, 2)
                //         : 0,
                // ];


                $agents = $team->users()
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'support_agent');
                    })
                    ->distinct()
                    ->get();



                $agentdata = [];

                foreach ($agents as $agent) {

                    $agentdata[] = [

                        'name' => $agent->name,

                        'total_ticket' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->count(),

                        'open' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Open')
                            ->count(),

                        'closed' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Closed')
                            ->count(),

                        'pending' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Pending')
                            ->count(),

                        'overdue' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Overdue')
                            ->count(),
                    ];
                }



                $content = view(
                    'teamreport',
                    compact(
                        'teamOverview',
                        'ticketStatus',
                        'slaData',

                        'agentdata',
                        'team',
                        'leader'
                    )
                )->render();



                Storage::disk('public')->makeDirectory('reports');

                $filename = "reports/teamreport_{$team->id}_" . now()->format('Y-m-d') . ".html";

                Storage::disk('public')->put($filename, $content);


                TeamReport::create([
                    'team_id' => $team->id,
                    'file_path' => $filename,
                    'report_date' => now()->toDateString(),
                ]);
                // TeamReport::updateOrCreate(

                //     [
                //         'team_id' => $team->id,
                //         'report_date' => now()->toDateString(),
                //     ],

                //     [
                //         'file_path' => $filename,
                //     ]
                // );

                $this->info("Report Generated: {$team->name}");
            }
        }

        $this->info('All Team Reports Generated Successfully');
    }
}


    // TeamReport::updateOrCreate(

//     [
//         'team_id' => $team->id,
//         'report_date' => now()->toDateString(),
//     ],

//     [
//         'file_path' => $filename,
//     ]
// );


// namespace App\Console\Commands;

// use Illuminate\Console\Attributes\Description;
// use Illuminate\Console\Attributes\Signature;
// use Illuminate\Console\Command;
// use App\Models\User;
// use App\Models\Ticket;
// use App\Models\Report;
// use App\Models\Team;
// use App\Models\TeamReport;
// use Illuminate\Support\Facades\Storage;
// // #[Signature('app:leader-daily-performance-report')]
// // #[Description('Command description')]
// class LeaderDailyPerformanceReport extends Command
// {

//     protected $signature = 'app:leader-daily-performance-report';

//     protected $description = 'Command description';
//     /**
//      * Execute the console command.
//      */
//     public function handle()
//     {
//         $leaders = User::role('team_leader')->get();
//         foreach ($leaders as $leader) {
//             $teams = Team::where('leader_id', $leader->id)->get();


//             foreach ($teams as $team) {

//                 $teamdata = [
//                     'totaltickets' => Ticket::where('assigned_team_id', $team->id)->count(),

//                     'open' => Ticket::where('assigned_team_id', $team->id)
//                         ->where('status', 'Open')->count(),

//                     'close' => Ticket::where('assigned_team_id', $team->id)
//                         ->where('status', 'Closed')->count(),

//                     'pending' => Ticket::where('assigned_team_id', $team->id)
//                         ->where('status', 'Pending')->count(),

//                     'overdue' => Ticket::where('assigned_team_id', $team->id)
//                         ->where('status', 'Overdue')->count(),
//                 ];
//                 // connected user with team 

//                 $agents = $team->users()
//                     ->whereHas('roles', function ($q) {        //filter roles table 
//                         $q->where('name', 'support_agent');
//                     })
//                     ->distinct()
//                     ->get();

//                 $agentdata = [];

//                 foreach ($agents as $agent) {

//                     $agentdata[] = [

//                         'name' => $agent->name,

//                         'totalticket' => Ticket::where('assigned_team_id', $team->id)
//                             ->where('assigned_agent_id', $agent->id)
//                             ->count(),

//                         'open' => Ticket::where('assigned_team_id', $team->id)
//                             ->where('assigned_agent_id', $agent->id)
//                             ->where('status', 'Open')
//                             ->count(),

//                         'close' => Ticket::where('assigned_team_id', $team->id)
//                             ->where('assigned_agent_id', $agent->id)
//                             ->where('status', 'Closed')
//                             ->count(),

//                         'pending' => Ticket::where('assigned_team_id', $team->id)
//                             ->where('assigned_agent_id', $agent->id)
//                             ->where('status', 'Pending')
//                             ->count(),

//                         'overdue' => Ticket::where('assigned_team_id', $team->id)
//                             ->where('assigned_agent_id', $agent->id)
//                             ->where('status', 'Overdue')
//                             ->count(),
//                     ];
//                 }

//                 $content = view('teamreport', compact('teamdata', 'agentdata', 'team'))->render();

//                 $filename = "reports/teamreport_{$team->id}_" . date('Y-m-d') . ".html";

//                 Storage::disk('public')->put($filename, $content);

//                 TeamReport::create([
//                     'team_id' => $team->id,
//                     'file_path' => $filename,
//                     'report_date' => now()->toDateString(),
//                 ]);

//                 $this->info("Team report generated: " . $team->name);
//             }
//         }
//         $this->info('All Team Reports Generated Successfully');
//     }
// }