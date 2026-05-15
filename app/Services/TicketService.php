<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;

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

        return Ticket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'attachment' => $path,
            'status' => $request->status,
        ]);
    }

    public function ticketlist()
    {
        // return view("customer.ticketlist", compact("ticket"));
        $tickets = Ticket::all();
        // dd(Ticket::all());
        return view("customer.ticketlist", compact("tickets"));
    }
}
