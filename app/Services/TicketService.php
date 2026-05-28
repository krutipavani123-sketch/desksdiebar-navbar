<?php

namespace App\Services;

use App\Mail\TicketAssignNotificationMail;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Team;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendmailqueue;
use App\Mail\TicketCreateMailNotification;
use Carbon\Carbon;
use App\Models\Notification;
use Carbon\CarbonPeriod;
use App\Models\ActivityLog;

use App\Models\Category;

class TicketService
{

    public function getCategories()
    {
        return Cache::remember('categories', 300, function () {
            return Category::all();
        });
    }
    public function addticket(Request $request)
    {
        $path = null;
        if ($request->hasFile("attachment")) {
            $file = $request->file("attachment");

            if ($file->isValid()) {
                $path = $file->store("images", "public");
            }
        }

        $teamId = $request->team_id;
        // $category=Category::find($request->category->id);
        // $teamId=$category->team_id;
        $team = Team::with('teamagents')->findOrFail($teamId);

        $agentId = null;
        if ($team) {
            $agentsid = $team->teamagents->pluck('id');

            if ($agentsid->isNotEmpty()) {
                $busyagent = User::whereIn('id', $agentsid)
                    ->withCount([
                        'assignedticket as openticketcount' => function ($query) {
                            $query->whereNotIn('status', ['Closed']);
                        }
                    ])->orderBy('openticketcount', 'asc')->first();

                if ($busyagent) {
                    $agentId = $busyagent->id;
                }
            }
        }

        $now = Carbon::now(); //current time

        if ($request->priority == 'Low') {
            $sla_deadline = 72;
        } elseif ($request->priority == 'Medium') {
            $sla_deadline = 24;
        } elseif ($request->priority == 'High') {
            $sla_deadline = 8;
        } elseif ($request->priority == 'Checking') {
            $sla_deadline = 4;
        } else {
            $sla_deadline = 2;
        }

        $deadline = $now->copy()->addHours($sla_deadline);

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            //'category' => $request->category,
                'category_id' => $request->category_id,
           // 'category_id' => $team->category_id,
            'attachment' => $path,
            'status' => 'Open',
            'assigned_team_id' => $teamId,
            'assigned_agent_id' => $agentId,
            'customer_id' => auth()->id(),
            'sla_deadline' => $deadline
        ]);

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'Ticket Created',
            'old_value' => null,
            'new_value' => 'Ticket Created'

        ]);
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Ticket Created',
            'message' => "Ticket {$ticket->id} Created successfully",
            'type' => 'Created'
        ]);

        if ($agentId) {
            Notification::create([
                'user_id' => $agentId,
                'title' => 'Ticket Assigned',
                'message' => "Ticket {$ticket->id} Assgined successfully ",
                "type" => "Assigned"
            ]);
        }

        if ($agentId && isset($busyagent)) {
            Mail::to($busyagent)->queue(new TicketAssignNotificationMail($ticket));
        }
        return true;
    }


    public function ticketlist(Request $request)
    {
        $user = auth()->user();
        $query = Ticket::with(['team', 'agent']);  // team and agent relation load
        if ($user->hasRole('team_leader')) {
            $team = Team::where('leader_id', $user->id)
                ->pluck('id');

            $query->where(function ($q) use ($team) {
                $q->whereIn('assigned_team_id', $team)
                    ->orWhereNull('assigned_agent_id'); //unassigned agent
            });
        } elseif ($user->hasRole('support_agent')) {
            $query->where('assigned_agent_id', $user->id);
            // show their assigned ticket 

        } elseif ($user->hasRole('customer')) {
            $query->where('customer_id', $user->id); // view own ticket
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orwhere('description', 'like', "%{$search}%");
            });
        }
        //   $agents = User::role('support_agent')->get();

        // $tickets = $query->get();
        $tickets = $query->with('comments.user')->get();

        // leader  can only see their team when assign ticket
        if ($user->hasRole('team_leader')) {
            $teams = Team::where('leader_id', $user->id)->get();
        } else {
            $teams = Team::all();
        }

        // $tickets = Ticket::with(['team', 'agent', 'comments.user'])->get();


        return view('customer.ticketlist', compact('tickets', 'teams'));
        // return view('customer.ticketlist', compact('tickets', 'teams', 'agents'));
    }


    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);


        $comment =  Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);


        return back()->with('success', 'Comment added');
    }











    // public function addticket(Request $request)
    // {
    //     $path = null;

    //     if ($request->hasFile('attachment')) {

    //         $file = $request->file('attachment');

    //         if ($file->isValid()) {
    //             $path = $file->store('images', 'public');
    //         }
    //     }

    //     $teamId = $request->team_id;

    //     $agentId = DB::table('teams')
    //         ->where('id', $teamId)
    //         ->value('assigned_agent_id');

    //     $now = Carbon::now();

    //     if ($request->priority == 'Low') {
    //         $sla_deadline = 72;
    //     } elseif ($request->priority == 'Medium') {
    //         $sla_deadline = 24;
    //     } elseif ($request->priority == 'High') {
    //         $sla_deadline = 8;
    //     } elseif ($request->priority == 'Checking') {
    //         $sla_deadline = 4;
    //     } else {
    //         $sla_deadline = 2;
    //     }
    //     $deadline = $now->copy()->addMinutes($sla_deadline);

    //     $ticket = Ticket::create([
    //         'subject' => $request->subject,
    //         'description' => $request->description,
    //         'priority' => $request->priority,
    //         'category' => $request->category,
    //         'attachment' => $path,
    //         'status' => 'Open',
    //         'assigned_team_id' => $teamId,
    //         'assigned_agent_id' => $agentId,  // assign automatic agentid 
    //         'customer_id' => auth()->id(),
    //         'sla_deadline' => $deadline,
    //     ]);



    //     // $agentId = $agentId ?? null;

    //     // if (!empty($agentId)) {
    //     //     $this->createnotification(
    //     //         $agentId,
    //     //         'New Ticket Created',
    //     //         "Ticket #{$ticket->id} created and assigned to you",
    //     //         'created'
    //     //     );
    //     // }

    //     // $tickets = Ticket::all();

    //     // foreach ($tickets as $ticket) {
    //     //     if ($ticket->status != 'Closed' && now()->greaterThan($ticket->sla_deadline)) {
    //     //         $ticket->status = 'Overdue';
    //     //         $ticket->save();
    //     //     }
    //     // }

    //     // if (now()->greaterThan($ticket->sla_deadline)) {
    //     //     $ticket->status = 'Overdue';
    //     //     $ticket->save();
    //     // }

    //     Notification::create([
    //         'user_id' => auth()->id(),
    //         'title' => 'Ticket Created',
    //         'message' => "Ticket Created for {$ticket->id}",
    //         'type' => 'created'
    //     ]);
    //     if ($agentId) {
    //         Notification::create([
    //             'user_id' => $agentId,
    //             'title' => 'New Ticket Assigned',
    //             'message' => "Ticket #{$ticket->id} assigned to you",
    //             'type' => 'assigned',
    //             'is_read' => 0,
    //         ]);
    //     }

    //     Mail::to(auth()->user()->email)
    //         ->queue(new TicketCreateMailNotification($ticket));

    //     return redirect()->route('customer.ticketlist')->with('success', 'Ticket created successfully');
    //     // Mail::to(auth()->user()->email)->send(new sendmailqueue($ticket));

    //     // return response()->json([
    //     //     'message' => 'Ticket created and email sent'
    //     // ]);
    // }



    // private function createnotification($userid, $title, $message, $type)
    // {
    //     Notification::create([
    //         'user_id' => $userid,
    //         'title' => $title,
    //         'message' => $message,
    //         'type' => $type,
    //         'is_read' => false
    //     ]);
    // }
}
