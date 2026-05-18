<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Services\TicketService;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Team;

class TicketController extends Controller
{
    protected $ticketservice;

    public function __construct(TicketService $ticketservice)
    {
        $this->ticketservice = $ticketservice;
    }
    public function create()
    {
        return view("customer.createticket");
    }


    public function addticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required|not_in:Default",  //must  change 
            "category" => "required|not_in:Default",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',   //10mb
            "status" => "required",
            // 'team_id' => 'required|exists:teams,id',
            // 'ticket_id' => 'required|exists:tickets,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->ticketservice->addticket($request);
        return redirect()->route('customer.ticketlist')->with("success", "Ticket created successfully!");
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
        $tickets = Ticket::findOrFail($id);
        //return redirect()->route('customer.edit', compact('tickets'));
        return view('customer.editticket', compact('tickets'));
    }

    public function update(Request $request, $id)
    {
        $tickets = Ticket::findOrFail($id);
        $validator = Validator::make($request->all(), [
            "subject" => "required",
            "description" => "required",
            "priority" => "required|not_in:Default",
            "category" => "required|not_in:Default",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',
            "status" => "required",
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


            if ($request->hasFile('attachment')) {

                if ($tickets->attachment) {
                    storage::disk('public')->delete($request->attachment);
                }

                $path = $request->file('attachment')->store('images', 'public');

                $tickets->attachment = $path;
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


    public function assignticket(Request $request)
    {
        $request->validate([
            'ticket_ids' => 'required|array',
            'team_id' => 'required|exists:teams,id',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        $teamId = $request->team_id;
        $agentId = DB::table('teams')
            ->where('id', $teamId)
            ->value('assigned_agent_id');


        Ticket::whereIn('id', $request->ticket_ids)
            ->update([
                'assigned_team_id' => $request->team_id,
                'assigned_agent_id' =>  $agentId,
            ]);



        // if ($user && $user->hasRole('team_leader')) {

        //     Ticket::whereIn('id', $request->ticket_ids)
        //         ->update([
        //             'assigned_team_id' => $request->team_id,
        //             'assigned_agent_id' => $request->agent_id,
        //         ]);
        // } else {
        //     Ticket::whereIn('id', $request->ticket_ids)
        //         ->update([
        //             'assigned_team_id' => $request->team_id,
        //             'assigned_agent_id' => $request->agent_id,
        //         ]);
        // }
        //dd($request->request->all());




        // Ticket::whereIn('id', $request->ticket_ids)
        //     ->update([
        //         'assigned_team_id' => $request->team_id
        //     ]);

        return redirect()->back()->with('success', 'Tickets assigned successfully');
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
