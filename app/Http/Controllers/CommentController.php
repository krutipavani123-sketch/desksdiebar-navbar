<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;

class CommentController extends Controller
{


    public function addcomment(Request $request)
    {

        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment'   => 'required|string'
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if (auth()->user()->hasRole('Customer')) {

            // customer can only add comment own ticket 
            if ($ticket->customer_id != auth()->id()) {
                abort(403);
            }
        }
        Comment::Create([
            'ticket_id' => $request->ticket_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => $request->has('is_internal') ? 1 : 0,
        ]);

        return back()->with('success', 'Comment Added');
    }
    //return view('comment', 'comment');
    //  return redirect()->route('customer.comment')->with('success','Comment Add');


    public function create($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('customer.comment', compact('ticket'));
    }

    public function commentlist($id)
    {
        $ticket = Ticket::with('comments.user')->findOrFail($id);

        $comments = $ticket->comments;

        return view('customer.commentlist', compact('comments', 'ticket'));
    }
}
