<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\InternalNote;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class InternalNoteController extends Controller
{

    public function create()
    {
        //  $ticket = Ticket::findOrFail($id);
        return view('internalnote.internalnote');
    }

    public function shownote($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('internalnote.internalnote', compact('ticket'));
    }

    public function notes(Request $request, $id)
    {
        $request->validate([
            "note" => "required|string",
        ]);

        if (auth()->user()->hasRole("customer")) {
            return back()->with("Error", "Not allowed");
        }
        $ticket = Ticket::findOrFail($id);

        $ticket->internalnote()->create([
            "user_id" => auth()->id(),
            "note" => $request->note,
        ]);

        $users = User::Role([
            'superadmin',
            'admin',
            'team_leader',
            'support_agent'
        ])->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id(),
                'title' => 'Internal Note Added',
                'message' => "Internal Note Added For {$ticket->id} Ticket",
                'type' => 'InternalNote'
            ]);
        }



        return redirect()->route('internalnote.notelist')->with("success", "Note Added");
    }

    public function notelist()
    {
        // $request->validate([
        //     "note" => "required|string",
        // ]);

        if (auth()->user()->hasRole("customer")) {
            return back()->with("Error", "Not allowed");
        }

        $user = auth()->user();
        // $ticket = Ticket::findOrFail($id);
        if ($user->hasAnyRole([
            "superadmin",
            "admin",
            "team_leader",
            "support_agent"
        ])) {
            $query = InternalNote::query(); // query builder (like select query) model

            if (request()->filled('search')) {
                $search = request()->search;
                $query->where('note', 'like', "%{$search}%");
            }
            $notes = $query->with('user')->get();

            return view('internalnote.notelist', compact('notes', 'user'));
        }
    }

    public function editnote($id)
    {
        // if (auth()->user()->hasRole('customer')) {
        //     return back()->with('Error', 'Not Edit');
        // }
        $note = InternalNote::findOrFail($id);
        return view('internalnote.editnote', compact('note'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->hasAnyRole(
            'superadmin',
            'admin',
            'team_leader',
            'support_agent'
        )) {
            $note =  InternalNote::findOrFail($id);
            $validator = Validator::make($request->all(), [
                "note" => "required|string",
            ]);

            if ($validator->fails()) {
                return back()->with('Error', $validator->errors()->first());
            } else {

                $note->note = $request->note;
                $note->save();
                return redirect()->route('internalnote.notelist')->with('success', 'Update');
            }
        }
    }

    public function deletenote($id)
    {
        $note = InternalNote::findOrFail($id);
        $note->delete();
        return redirect()->route('internalnote.notelist')->with('success', 'Note Deleted');
    }
}
