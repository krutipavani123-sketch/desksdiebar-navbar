<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Services\TicketService;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAssignNotificationMail;
use App\Mail\TicketCreateMailNotification;
use App\Mail\TicketCloseNotificationMail;
use App\Mail\TicketReopenedMail;
use App\Models\Notification;

class TicketController extends Controller
{
    protected $ticketservice;

    public function __construct(TicketService $ticketservice)
    {
        $this->ticketservice = $ticketservice;
    }
    public function create()
    {
        $teams = Team::all();
        return view("customer.createticket", compact('teams'));
    }


    public function addticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required|not_in:Default",  //must  change 
            "category" => "required|not_in:Default",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',   //10mb
            //"status" => "required",
            'team_id' => 'required|exists:teams,id',
            // 'ticket_id' => 'required|exists:tickets,id',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->ticketservice->addticket($request);

        // Mail::to(auth()->user()->email)
        //     ->send(new TicketCreateMailNotification($request));


        return redirect()->route('customer.ticketlist')->with("success", "Ticket created && Assigned successfully!");
        // $result = $this->ticketservice->addticket($request);

        // dd($result);
    }
    public function ticketlist(Request $request)
    {
        //return view("customer.ticketlist");
        //  $agents = Team::with('agents')->get();
        return $this->ticketservice->ticketlist($request);
    }

    public function edit(Request $request, $id)
    {
        //        $tickets = Ticket::findOrFail($id);

        $tickets = Ticket::with('comments')->findOrFail($id);

        //return redirect()->route('customer.edit', compact('tickets'));
        return view('customer.editticket', compact('tickets'));
    }

    public function update(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($id);

        //dd($request->all());
        //$tickets = Ticket::with('comments')->findOrFail($id);
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required|not_in:Default",
            "category" => "required|not_in:Default",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',
            //  "status" => "required", 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $tickets->subject = $request->subject;
            $tickets->description = $request->description;
            $tickets->priority = $request->priority;
            $tickets->category = $request->category;
            // $tickets->attachment = $request->attachment;
            $tickets->status = $request->status;



            if ($request->has('remove_attachment') && $request->remove_attachment == 1) {
                if ($tickets->attachment) {
                    Storage::disk('public')->delete($tickets->attachment);
                }
                $tickets->attachment = null;
            }

            if ($request->hasFile('attachment')) {

                if ($tickets->attachment) {
                    Storage::disk('public')->delete($tickets->attachment);
                }

                $file = $request->file('attachment');
                $path = $file->store('images', 'public');

                $tickets->attachment = $path;
            }


            if ($request->filled('comment')) {
                // $latestComment = $tickets->comments();
                $latestComment = $tickets->comments()->latest()->first();

                if ($latestComment) {
                    $latestComment->update([
                        'comment' => $request->comment
                    ]);
                }
            }

            $tickets->save();

            return redirect()->route("customer.ticketlist")->with("success", "Ticket Updated");
        }
    }

    public function delete(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($id);
        $tickets->delete();
        return redirect()->route("customer.ticketlist")->with("success", "Ticket Deleted");
    }

    public function assignticket(Request $request, $id)
    {
        $request->validate([
            "ticket_ids" => "required|array",
            "team_id" => "required|exists:teams,id",
        ]);

        $teamid = $request->team_id;

        $team = Team::with('teamagents')->findOrFail($teamid);

        $agentsid = $team->teamagents->pluck('id');

        if ($agentsid->isEmpty()) {
            return back()->with('error', 'No Agents Available');
        }

        $busyagent = User::whereIn('id', $agentsid)
            ->withCount([
                'assignedticket as openticketcount' => function ($query) {
                    $query->whereNotIn('status', ['Closed']);
                }
            ])
            ->orderBy('openticketcount', 'asc')->first();

        if (!$busyagent) {
            return back()->with('error', 'No agent Available');
        }

        Ticket::whereIn('id', $request->ticket_ids)->update([
            'assigned_agent_id' => $busyagent->id,
            'assigned_team_id' => $teamid,
        ]);

        $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();

        foreach ($tickets as $ticket) {

            Notification::create([
                'user_id' => $busyagent->id,
                'title' => 'Ticket Assigned',
                'message' => "Ticket {$ticket->id} assigned",
                "type" => 'Assgined',
            ]);

            Mail::to($busyagent->email)->queue(
                new TicketAssignNotificationMail($ticket)
            );
        }
    }

    // public function assignticket(Request $request)
    // {
    //     $request->validate([
    //         'ticket_ids' => 'required|array',
    //         'team_id' => 'required|exists:teams,id',
    //         'agent_id' => 'nullable|exists:users,id',
    //     ]);

    //     $teamId = $request->team_id;
    //     $user = auth()->id();

    //     $agentId = DB::table('teams')
    //         ->where('id', $teamId)    //match id    
    //         ->value('assigned_agent_id');  //fetch that id

    //     //fetch id 
    //     $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();

    //     Ticket::whereIn('id', $request->ticket_ids)    //find id inside array
    //         ->update([
    //             'assigned_team_id' => $teamId,
    //             'assigned_agent_id' =>  $agentId,
    //         ]);
    //     $agent = User::find($agentId);

    //     if ($agent) {
    //         foreach ($tickets as  $ticket) {

    //             Notification::create([
    //                 'user_id' => $agentId,
    //                 'title' => 'New Ticket Assigned',
    //                 'message' => "Ticket {$ticket->id} has been assigned to you",
    //                 'type' => 'assigned'
    //             ]);

    //             Mail::to($agent->email)
    //                 ->queue(new TicketAssignNotificationMail($ticket));
    //         }


    //         return redirect()->back()->with('success', 'Tickets assigned successfully');
    //     }
    // }
    // public function comment(Request $request, $id)
    // {
    //     return $this->ticketservice->comment($request, $id);
    // }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);

        //   $comment = Comment::findOrFail($id);
        // $user = User::findOrFail($id);
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
        ]);
        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Comment Added',
            'message' => "Comment Added on Ticket {$ticket->id}",
            'type' => 'comment',
            'is_read' => 0,
        ]);

        return back()->with('success', 'Comment added');
    }


    public function show($id)
    {
        $ticket = Ticket::with('comments.user')->findOrFail($id);
        return view('customer.show', compact('ticket'));
    }
    public function commentlist()

    {
        $comments = Comment::all();
        return view('customer.commentlist', compact('comments'));
    }

    // public function editcomment(Request $request, $id)
    // {
    //     return $this->ticketservice->editcomment($request, $id);
    // }



    public function updatestatus(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $request->validate([
            'status' => 'required',
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return redirect()->route('customer.ticketlist')
            ->with('success', 'Status Updated');
    }

    public function statuspage($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('customer.updatestatus', compact('ticket'));
    }


    public function resolve($id)
    {
        $ticket = Ticket::with('comments')->findOrFail($id);  // load comments
        return view('customer.resolve', compact('ticket'));
    }

    public function updateResolve(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 'Closed';  //permienently close
        //  $ticket->status = $request->status;
        $ticket->resolution = $request->resolution;

        //$ticket->resolved_at = now(); 
        $ticket->save();


        Notification::create([
            'user_id' => $ticket->customer_id,
            'title' => 'Ticket Closed',
            'message' => "Ticket {$ticket->id} has been closed",
            'type' => 'Closed',
        ]);
        //ticket created user receive mail
        Mail::to($ticket->customer?->email)
            ->queue(new TicketCloseNotificationMail($ticket));


        return redirect()->route('customer.ticketlist')->with('success', 'Ticket Resolved');
    }

    public function reopen($id)
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->status != 'Closed') {
            return redirect()->back()->with('error', 'Only Close Ticket Reopen');
        }
        $ticket->status = 'ReOpened';
        $ticket->save();

        Notification::create([
            'user_id' => $ticket->assigned_agent_id,
            'title' => 'Ticket Reopen',
            'message' => "Ticket {$ticket->id} has been ReOpened",
            "type" => "ReOpened",
        ]);

        if ($ticket->agent) {
            Mail::to($ticket->agent->email)
                ->queue(new TicketReopenedMail($ticket));
        }

        return redirect()->route('customer.ticketlist')->with('success', 'Ticket Reopened successfully');
    }
}















    // public function reassignticket(Request $request)
    // {

    //     $this->ticketservice->reassignticket($request);

    //     return redirect()->back()->with('success', 'Ticket Reassigned Successfully');
    // }

//     public function assignticket(Request $request)
//     {
//         Ticket::whereIn('id', $request->ticket_ids)
//             ->update([
//                 'assigned_team_id' => $request->team_id
//             ]);

//         return redirect()->back()->with('success', 'Assigned');
//     }

//     public function reassignteam(Request $request, $ticketId)
//     {
//         return $this->ticketservice->reassignteam($request, $ticketId);
//     }
// }
