<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class GenerateReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {

    //     $users = User::count();
    //     $tikcets = Ticket::count();


    //     $content = "Daily Report\n";
    //     $content .= "Users : $users";          // use .= that append content
    //     $content .= "Tickets : $tikcets";

    //     $filename = "reports/report_" . date('Y_m_d') . ".txt";

    //     Storage::disk('public')->put($filename, $content);

    //     Report::create([
    //         'file_path' => $filename,
    //         'report_date' => now()->toDateString(),
    //     ]);
    // }
}
