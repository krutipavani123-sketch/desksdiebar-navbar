<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Report;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

// #[Signature('app:generate-daily-report')]
// #[Description('Command description')]
class GenerateDailyReport extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'app:generate-daily-report';      //cmd name
    protected $description = 'Command description';    // show in list name

    public function handle()
    {

        // $users = User::count();
        // $tikcets = Ticket::count();


        // $content = "Daily Report\n";
        // $content .= "Users : $users\n";          // use .= that append content
        // $content .= "Tickets : $tikcets\n";

        $ticketsummary = [
            'total' => Ticket::count(),

            'open' => Ticket::where('status', 'Open')->count(),
            'close' => Ticket::where('status', 'Closed')->count(),
            'pending' => Ticket::where('status', 'Pending')->count(),

        ];

        $agents = User::role('support_agent')
            ->withcount([
                'assignedticket as totaltickets',
                'assignedticket as closetickets' =>
                function ($q) {
                    $q->where('status', 'Closed');
                }
            ])->get();

        $slabreached = Ticket::where('status', '!=', 'Closed')
            ->whereNotNull('sla_deadline')
            ->where('sla_deadline', '<', now())
            ->count();

        $slaOk = Ticket::where('status', 'Closed')->count();


        $customers = User::role('customer')
            ->withcount('customertickets')->get();

        $content = view('reportview', compact(
            'ticketsummary',
            'agents',
            'slabreached',
            'slaOk',
            'customers'
        ))->render();
        // Convert blade in html


        $filename = "reports/report_" . date('Y_m_d') . ".html";

        Storage::disk('public')->put($filename, $content);



        // Report::create([
        //     'file_path' => $filename,
        //     'report_date' => now()->toDateString(),
        // ]);

        Report::updateOrCreate(
            [
                //search condition
                'report_date' => now()->toDateString(),
            ],
            [
                'file_path' => $filename,
            ]
        );
        $this->info("Report generated successfully!");
    }
}











// $pdf = Pdf::loadView('reportview', compact(
//             'ticketsummary',
//             'agents',
//             'slabreached',
//             'slaOk',
//             'customers'
//         ));

//         $filename = "reports/report_" . now()->format('Y_m_d_H_i_s') . ".pdf";

//         Storage::disk('public')->put($filename, $pdf->output());