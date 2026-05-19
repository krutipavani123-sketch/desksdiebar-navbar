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
        // $teamId = $request->team_id;
        // $agent = User::where('team_id', $teamId)->first(); //find team agent
        // $teamId = DB::table('team_user')
        //     ->where('user_id', auth()->id())
        //     ->value('team_id');

        $teamId = $request->team_id;

        $agentId = DB::table('teams')
            ->where('id', $teamId)
            ->value('assigned_agent_id');



        // $agentId = DB::table('team_user')
        //    ->where('team_id', $teamId)    //Model::where('column_name', $value)->get();
        ///   ->value('user_id'); // first agent (assign automatic agentid )

         Ticket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'attachment' => $path,
            'status' => 'Open',
            'assigned_team_id' => $teamId,
            'assigned_agent_id' => $agentId,  // assign automatic agentid 
            'customer_id' => auth()->id(),
        ]);

        
    }

    public function ticketlist(Request $request)
    {
        $user = auth()->user();
        $query = Ticket::with(['team', 'agent']);  // team and agent relation load
        if ($user->hasRole('team_leader')) {
            $team = DB::table('team_user')
                ->where('user_id', $user->id)
                ->value('team_id');

            $query->where(function ($q) use ($team) { //team based filtering
                $q->where('assigned_team_id', $team)
                    ->orWhereNull('assigned_agent_id');
                // unassigned ticket show   
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

        $teams = Team::all();


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
    // public function reassignticket(Request $request)
    // {
    //     $request->validate([
    //         'ticket_ids' => 'required|array',
    //         'team_id' => 'required|exists:teams,id',
    //     ]);

    //     Ticket::whereIn('id', $request->ticket_ids)
    //         ->update([
    //             'assigned_team_id' => $request->team_id
    //         ]);

    //     // return redirect()->back()->with('success', 'Ticket Reassigned Successfully');
    // }


// if ($request->assigned_to) {
//     $ticket->assigned_to = $request->assigned_to;
// }


// <button type="submit" class="btn btn-success">
//     {{ $ticket->team_id ? 'Reassign' : 'Assign' }}
// </button>


// @foreach($tickets as $ticket)
// <div class="modal fade" id="assignModal{{ $ticket->id }}" tabindex="-1">



// <form action="{{ route('customer.assignticket') }}" method="POST">
//     @csrf

//     <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">


// public function assignTicket(Request $request)
// {
//     $request->validate([
//         'team_id' => 'required|exists:teams,id',
//         'ticket_id' => 'required|exists:tickets,id',
//     ]);

//     $ticket = Ticket::findOrFail($request->ticket_id);

//     $oldTeam = $ticket->team_id;

//     $ticket->update([
//         'team_id' => $request->team_id,
//     ]);

//     // Optional log
//     if ($oldTeam != $request->team_id) {
//         \Log::info("Ticket {$ticket->id} reassigned from {$oldTeam} to {$request->team_id}");
//     }

//     return back()->with('success',
//         $oldTeam ? 'Ticket Reassigned Successfully' : 'Ticket Assigned Successfully'
//     );
// }







    // public function ticketlist(Request $request)
    // {
    //     // return view("customer.ticketlist", compact("ticket"));
    //     //     $tickets = Ticket::all();
    //     //    $agents =Team::with('agents')->get();
    //     // dd(Ticket::all());

    //     // $teamId = DB::table('team_user')
    //     //     ->where('user_id', auth()->id())
    //     //     ->value('team_id');

    //     // $tickets = Ticket::where('assigned_team_id', $teamId)
    //     //     ->with('team')
    //     //     ->get();



    //     $query = Ticket::with('team');    //load with related team - tickets
    //     if ($request->filled('search')) {
    //         $search = $request->search;


    //         $query->where(function ($q) use ($search) {
    //             $q->where('subject', 'like', "%{$search}%")
    //                 ->orWhere('description', 'like', "%{$search}%");
    //         });
    //     }
    //     $tickets = $query->get();
    //     //   $tickets = Ticket::with('team')->get();
    //     $teams = Team::all();
    //     return view("customer.ticketlist", compact("tickets", "teams"));
    // }