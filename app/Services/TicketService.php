<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Team;

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

    public function ticketlist(Request $request)
    {
        // return view("customer.ticketlist", compact("ticket"));
        //     $tickets = Ticket::all();
        //    $agents =Team::with('agents')->get();
        // dd(Ticket::all());
        $query = Ticket::with('team');
        if ($request->filled('search')) {
            $search = $request->search;


            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        $tickets = $query->get();
        //   $tickets = Ticket::with('team')->get();
        $teams = Team::all();
        return view("customer.ticketlist", compact("tickets", "teams"));
    }
}
