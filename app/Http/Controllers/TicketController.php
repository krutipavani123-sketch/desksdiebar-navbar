<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  App\Services\TicketService;
use App\Models\Ticket;

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
            "priority" => "required|not_in:Default",
            "category" => "required|not_in:Default",
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',
            "status" => "required",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $this->ticketservice->addticket($request);
        return redirect()->route('customer.ticketlist')->with("success", "Ticket created successfully!");
        // $result = $this->ticketservice->addticket($request);

        // dd($result);
    }
    public function ticketlist()
    {
        //return view("customer.ticketlist");
        return $this->ticketservice->ticketlist();
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
}
