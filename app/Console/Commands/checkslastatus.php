<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

// #[Signature('app:checkslastatus')]
// #[Description('Command description')]
class checkslastatus extends Command
{
    /**
     * Execute the console command.
     */

    protected $signature = 'app:checkslastatus';
    protected $description = 'check SLA status and send notification';
    public function handle()
    {

        //update status
        Ticket::where('status', '!=', 'Closed')
            ->whereNotNull('sla_deadline')
            ->where('sla_deadline', '<', now())
            ->update([
                'status' => 'Overdue'
            ]);


        $tickets = Ticket::where('status', '!=', 'Closed')
            ->whereNotNull('sla_deadline')
            ->get();

        // difference between deadline & current time  and negative answer
        foreach ($tickets as $ticket) {
            $minutes = now()->diffInMinutes($ticket->sla_deadline, false); //negative value

            if ($minutes <= 1 && $minutes > 0) {
                Notification::create([
                    'user_id' => $ticket->assigned_agent_id,
                    'title' => 'SLA Warning',
                    'message' => "Ticket {$ticket->id} SLA Expires in {$minutes} Minutes",
                    'type' => 'Warning'
                ]);
            }
            $this->info('SLA check completed');
        }
    }
}
    // public function handle()
    // {
    //     $tickets = Ticket::where('status', '!=', 'Closed')->get();

    //     foreach ($tickets as $ticket) {
    //         if (now()->greaterThan($ticket->sla_deadline)) {
    //             $ticket->status = 'Overdue';
    //             $ticket->save();
    //         }
    //     }
    //     $this->info('SLA check completed'); //success msg
    // }
