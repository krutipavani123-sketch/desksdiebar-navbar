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

        return redirect()->route('customer.ticketlist')->with('success', 'Comment Added');
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

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        if (auth()->user()->hasRole('customer')) {
            if ($comment->user_id != auth()->id()) {
                abort(403);
            }
        }
        $comment->delete();
        return redirect()->route('customer.ticketlist')->with('success', 'Comment Deleted');
    }

    public function edit(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $ticket = Ticket::findOrFail($comment->ticket_id);

        return view('customer.editcomment', compact('comment', 'ticket'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);


        $validator = Validator::make($request->all(), [
            //'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required',
            'is_internal' => 'nullable'
        ]);

        $ticket = Ticket::findOrFail($comment->ticket_id);

        if (auth()->user()->hasRole('Customer')) {

            // customer can only add comment own ticket 
            if ($ticket->customer_id != auth()->id()) {
                abort(403);
            }
        }


        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        } else {
            $comment->comment = $request->comment;
            $comment->is_internal = $request->has('is_internal') ? 1 : 0;
            $comment->save();
        }

        return back()->with('success', 'Updated');
    }

    public function show($id)
    {
        $ticket = Ticket::with('comments.user')->findOrFail($id);

        $comments = $ticket->comments;

        return view('customer.show', compact('ticket','comments'));
    }
}
