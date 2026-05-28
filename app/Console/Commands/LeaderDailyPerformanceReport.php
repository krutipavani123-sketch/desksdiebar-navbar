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
            //get leader team
            $teams = Team::where('leader_id', $leader->id)->get();

            foreach ($teams as $team) {
                $teamoverview = [
                    'team_name' => $team->teamName,
                    'leader_name' => $leader->name,
                    //user connected with team
                    'totalagents' => $team->users()
                        ->whereHas('roles', function ($q) {
                            $q->where('name', 'support_agent');
                        })->count(),
                ];

                $ticketstatus = [
                    'total' => Ticket::where('assigned_team_id', $team->id)
                        ->count(),

                    'open' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Open')
                        ->count(),

                    'close' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Closed')
                        ->count(),

                    'pending' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Pending')
                        ->count(),


                    'inprogress' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'In Progress')
                        ->count(),

                    'overdue' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Overdue')
                        ->count(),
                ];

                $sladata = [
                    'slabreached' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', '!=', 'Closed')
                        ->whereNotNull('sla_deadline')
                        ->where('sla_deadline', '<', now())
                        ->count(),

                    'slacompleted' => Ticket::where('assigned_team_id', $team->id)
                        ->where('status', 'Closed')
                        ->count(),
                ];
                //user connected with team 
                $agents = $team->users()
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'support_agent');
                    })->get();

                $agentdata = [];

                foreach ($agents as $agent) {
                    $agentdata[] = [
                        'name' => $agent->name,

                        'totalticket' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->count(),

                        'open' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Open')
                            ->count(),

                        'close' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Closed')
                            ->count(),

                        'pending' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'Pending')
                            ->count(),

                        'inprogress' => Ticket::where('assigned_team_id', $team->id)
                            ->where('assigned_agent_id', $agent->id)
                            ->where('status', 'In Progress')
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
                        'teamoverview',
                        'ticketstatus',
                        'sladata',
                        'agentdata',
                        'team',
                        'leader'
                    )
                )->render(); //convert string into html
                // if folder is not exists then create
                Storage::disk('public')->makeDirectory('reports');

                $filename = "reports/teamreport_{$team->id}_" . now()->format('Y-m-d_H-i-s') . " .html";

                // file no that create or exist then overwrite
                Storage::disk('public')->put($filename, $content);

                // TeamReport::create([
                //     'team_id' => $team->id,
                //     'file_path' => $filename,
                //     'report_date' => now()->toDateString(),
                //     // keep date remove time 
                // ]);

                TeamReport::updateOrCreate(
                    [
                        //search condition 
                        'team_id' => $team->id,
                        'report_date' => now()->toDateString(),
                    ],
                    [
                        'file_path' => $filename,
                    ]
                );
                $this->info("Report Generated: {$team->name}");
            }
        }

        $this->info("All Team Reports Generated Successfully");
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