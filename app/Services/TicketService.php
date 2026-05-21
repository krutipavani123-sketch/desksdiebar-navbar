<?php

namespace App\Services;

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

class TicketService
{



    public function addticket(Request $request)
    {
        $path = null;

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            if ($file->isValid()) {
                $path = $file->store('images', 'public');
            }
        }

        $teamId = $request->team_id;

        $agentId = DB::table('teams')
            ->where('id', $teamId)
            ->value('assigned_agent_id');

        $now = Carbon::now();

        if ($request->priority == 'Low') {
            $sla_deadline = 72;
        } elseif ($request->priority == 'Medium') {
            $sla_deadline = 24;
        } elseif ($request->priority == 'High') {
            $sla_deadline = 8;
        } else {
            $sla_deadline = 2;
        }
        $deadline = $now->copy()->addHours($sla_deadline);

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'attachment' => $path,
            'status' => 'Open',
            'assigned_team_id' => $teamId,
            'assigned_agent_id' => $agentId,  // assign automatic agentid 
            'customer_id' => auth()->id(),
            'sla_deadline' => $deadline,
        ]);

        if (now()->greaterThan($ticket->sla_deadline)) {
            $ticket->status = 'Overdue';
            $ticket->save();
        }
        Mail::to(auth()->user()->email)
            ->queue(new TicketCreateMailNotification($ticket));

        return redirect()->route('customer.ticketlist')->with('success', 'Ticket created successfully');
        // Mail::to(auth()->user()->email)->send(new sendmailqueue($ticket));

        // return response()->json([
        //     'message' => 'Ticket created and email sent'
        // ]);
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

        Comment::create([
            'ticket_id' => $id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
        return back()->with('success', 'comment added');
    }
}
