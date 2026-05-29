<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
use Illuminate\Support\Facades\Cache;
use App\Models\ActivityLog;
use App\Models\CategoryTeamAgent;

class TicketController extends Controller
{
    protected $ticketservice;

    public function __construct(TicketService $ticketservice)
    {
        $this->ticketservice = $ticketservice;
    }

    function clearDashboardCache()
    {
        Cache::forget('dashboard_stats');
        Cache::forget('admindashboard_stats');
        Cache::forget('leaderdashboard_stats');
        Cache::forget('agentdashboard_stats');
        Cache::forget('customerdashboard_tasks');
    }
    public function create()
    {
        $teams = Team::all();
        Cache::forget('categories');
        $categories = $this->ticketservice->getCategories();

        return view("customer.createticket", compact('teams', 'categories'));
    }


    public function addticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required",  //must  change 
            "category_id" => "required|exists:categories,id",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',   //10mb
            //"status" => "required",
            'team_id' => 'required|exists:teams,id',
            // 'ticket_id' => 'required|exists:tickets,id',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->clearDashboardCache();
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
        $this->clearDashboardCache();
        return $this->ticketservice->ticketlist($request);
    }

    public function edit(Request $request, $id)
    {
        //        $tickets = Ticket::findOrFail($id);

        //$tickets = Ticket::with('comments')->findOrFail($id);
        $tickets = Ticket::with('comments')->findOrFail($id);
        $categories = Category::all();
        //return redirect()->route('customer.edit', compact('tickets'));
        return view('customer.editticket', compact('tickets', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($id);

        //dd($request->all());
        //$tickets = Ticket::with('comments')->findOrFail($id);
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required",
            "category_id" => "required|exists:categories,id",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',
            //  "status" => "required", 
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $oldpriority =   $tickets->priority;

            $tickets->subject = $request->subject;
            $tickets->description = $request->description;
            $tickets->priority = $request->priority;
            $tickets->category_id = $request->category_id;
            // $tickets->attachment = $request->attachment;
            $tickets->status = $request->status;

            // change category that time change assign team
            $category = Category::find($request->category_id);
            if ($category) {
                $tickets->assigned_team_id = $category->team_id;
            }

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
            $tickets->save();

            if ($oldpriority != $request->priority) {
                ActivityLog::create([
                    'ticket_id' => $tickets->id,
                    'user_id' => auth()->id(),
                    'action' => 'Priority Changed',
                    'old_value' => $oldpriority,
                    'new_value' => $request->priority
                ]);
            }
            // if ($request->filled('comment')) {
            //     // $latestComment = $tickets->comments();
            //     $latestComment = $tickets->comments()->latest()->first();

            //     if ($latestComment) {
            //         $oldcomment = $latestComment->comment;
            //         $latestComment->update([
            //             'comment' => $request->comment
            //         ]);
            // ActivityLog::create([
            //     'ticket_id' => $tickets->id,
            //     'user_id' => auth()->id(),
            //     'action' => 'Comment Updated',
            //     'old_value' => $oldcomment,
            //     'new_value' => $request->comment
            // ]);
            //     }
            // }
            $this->clearDashboardCache();
            $tickets->save();

            return redirect()->route("customer.ticketlist")->with("success", "Ticket Updated");
        }
    }

    public function delete(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($id);
        $tickets->delete();
        $this->clearDashboardCache();
        return redirect()->route("customer.ticketlist")->with("success", "Ticket Deleted");
    }

    public function assignticket(Request $request)
    {
        $request->validate([
            "ticket_ids" => "required|array",
            "team_id" => "required|exists:teams,id",
            "assigned_agent_id" => "nullable|exists:users,id",
        ]);
        $this->clearDashboardCache();

        $teamid = $request->team_id;

        $team = Team::with('teamagents')->findOrFail($teamid);
        $categoryid = $team->category_id;   //assign that time change category
        $agentsid = $team->teamagents->pluck('id');

        if ($agentsid->isEmpty()) {
            return back()->with('error', 'No Agents Available');
        }
        if ($request->filled('assigned_agent_id')) {
            $busyagent = User::where('id', $request->assigned_agent_id)->first();
        } else {
            $busyagent = User::whereIn('id', $agentsid)
                ->withCount([
                    'assignedticket as openticketcount' => function ($query) {
                        $query->whereNotIn('status', ['Closed']);
                    }
                ])
                ->orderBy('openticketcount', 'asc')->first();
        }
        if (!$busyagent) {
            return back()->with('error', 'No agent Available');
        }

        // Ticket::whereIn('id', $request->ticket_ids)->update([
        //     'assigned_agent_id' => $busyagent->id,
        //     'assigned_team_id' => $teamid,
        // ]);


        $tickets = Ticket::whereIn('id', $request->ticket_ids)->get();


        foreach ($tickets as $ticket) {
            $oldagent = $ticket->agent?->name ?? 'Unassigned';

            ActivityLog::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(),
                'action' => 'Ticket Assign',
                'old_value' => $oldagent,
                'new_value' => "Ticket Assign to {{$busyagent->name}}",
            ]);

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


        //$team_category_id = $team->category_id;  //assign that time change category
        Ticket::whereIn('id', $request->ticket_ids)->update([
            'assigned_agent_id' => $busyagent->id,
            'assigned_team_id' => $teamid,
            'category_id' => $categoryid,
        ]);

        return redirect()->route('customer.ticketlist')->with('success', 'Assigned');
    }


    public function comment(Request $request, $id)
    {

        $request->validate([
            'comment' => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);


        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
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
        $this->clearDashboardCache();
        return view('customer.commentlist', compact('comments'));
    }

    // public function editcomment(Request $request, $id)
    // {
    //     return $this->ticketservice->editcomment($request, $id);
    // }



    public function updatestatus(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $oldstatus = $ticket->status;
        // $request->validate([
        //     'status' => 'required',
        // ]);

        $ticket->status = $request->status;
        $ticket->save();

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'status changed',
            'old_value' => $oldstatus,
            'new_value' => $request->status,
        ]);


        $this->clearDashboardCache();
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
        $this->clearDashboardCache();
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
        $this->clearDashboardCache();
        return redirect()->route('customer.ticketlist')->with('success', 'Ticket Reopened successfully');
    }

    // public function ticketchart(Request $request)
    // {
    //     $data = Ticket::select('status', DB::raw('count(*) as total'))
    //         ->groupBy('status')
    //         ->pluck('total', 'status');

    //     return  view('chart', compact('data'));
    // }

    public function ticketchart(Request $request)
    {
        // return view('chart');

        $data = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $categories = $data->keys();   // use for x label

        $values = $data->values();    // use for y label

        $series = [
            'type' => 'column',
            'name' => 'Tickets',
            'data' => $values
        ];

        $pie = [];
        foreach ($data as $status => $count) {    // key => value
            $pie[] = [
                'name' => $status,
                'y' => $count
            ];
        }
        return view('chart', compact('categories', 'series', 'pie'));
    }
}









// public function ticketHighchart()
// {
//     $data = Ticket::select('status', DB::raw('count(*) as total'))
//         ->groupBy('status')
//         ->pluck('total', 'status');

//     return view('customer.ticket-chart', compact('data'));
// }





























































































































































































































































 // public function autoassignticket(Request $request,$id){

    // $request->validate([
    //     'assigned_agent_id'=> '$required|exists:users,id',
    // ]);
    //     $ticket = Ticket::findOrFail(request('id'));


    //     $ticket->assigned_agent_id=$request->assigned_agent_id;
    //     $ticket->save();

    //     return redirect()->route('customer.ticketlist')->with('success','Ticket Assigned Successfully');
    // }




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