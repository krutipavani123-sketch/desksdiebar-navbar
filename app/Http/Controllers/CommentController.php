<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;

use App\Models\ActivityLog;

class CommentController extends Controller
{


    public function addcomment(Request $request)
    {
        $path = null;

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');

            if ($file->isValid()) {
                $path = $file->store('images', 'public');
            }
        }


        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'comment'   => 'required|string',
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',   //10mb
        ]);

        $ticket = Ticket::findOrFail($request->ticket_id);

        if (auth()->user()->hasRole('Customer')) {

            // customer can only add comment own ticket 
            if ($ticket->customer_id != auth()->id()) {
                abort(403);
            }
        }
        $comment = Comment::Create([
            'ticket_id' => $request->ticket_id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => $request->has('is_internal') ? 1 : 0,
            'attachment' => $path
        ]);
        if ($ticket->customer_id) {
            Notification::create([
                'user_id' => $ticket->customer_id,
                'title' => 'New Comment Added',
                'message' => "New comment on Ticket {$ticket->id}",
                'type' => 'comment',
                'is_read' => 0,
            ]);
        }


        if ($ticket->assigned_agent_id) {
            Notification::create([
                'user_id' => $ticket->assigned_agent_id,
                'title' => 'New Comment Added',
                'message' => "New comment on Ticket {$ticket->id}",
                'type' => 'comment',
                'is_read' => 0,
            ]);
        }
        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'Comment Added',
            'old_value' => null,
            'new_value' => $comment->comment,
        ]);
        return redirect()->route('customer.commentlist', $request->ticket_id)
            ->with('success', 'Comment Added');
    }
    //return view('comment', 'comment');
    //  return redirect()->route('customer.comment')->with('success','Comment Add');


    public function create($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('customer.comment', compact('ticket'));
    }

    public function commentlist(Request $request, $id)
    {
        $ticket = Ticket::with('comments.user')->findOrFail($id);

        $comments = $ticket->comments;

        if ($request->filled('search')) {
            $search = $request->search;
            $comments->where('name', 'like', "%{$search}%");
        }
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
        //    $tickets = Ticket::findOrFail($id);

        $validator = Validator::make($request->all(), [
            //'ticket_id' => 'required|exists:tickets,id',
            'comment' => 'required',
            'is_internal' => 'nullable',
            "attachment" =>  'nullable|mimes:jpeg,png,jpg,pdf,xls,xlsx|max:10240',   //10mb

        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $ticket = Ticket::findOrFail($comment->ticket_id);

        if (auth()->user()->hasRole('Customer')) {

            // customer can only add comment own ticket 
            if ($ticket->customer_id != auth()->id()) {
                abort(403);
            }
        }



        $oldcomment = $comment->comment;
        $comment->comment = $request->comment;
        //  $comment->is_internal = $request->has('is_internal') ? 1 : 0;
        $comment->is_internal = $request->is_internal;

        if ($request->has('remove_attachment') && $request->remove_attachment == 1) {
            if ($comment->attachment) {
                Storage::disk('public')->delete($comment->attachment);
            }
            $comment->attachment = null;
        }

        if ($request->hasFile('attachment')) {

            if ($comment->attachment) {
                Storage::disk('public')->delete($comment->attachment);
                //replace old img with new img
            }

            $path = $request->file('attachment')->store('images', 'public');

            $comment->attachment = $path;
        }
        $comment->save();

        if ($ticket->customer_id) {

            Notification::create([
                'user_id' => $ticket->customer_id,
                'title' => 'Comment Updated',
                'message' => "Comment Updated For Ticket {$ticket->id}",
                'type' => 'comment',
                'is_read' => 0,
            ]);
        }

        if ($ticket->assigned_agent_id) {

            Notification::create([
                'user_id' => $ticket->assigned_agent_id,
                'title' => 'Comment Updated',
                'message' => "Comment Updated For Ticket {$ticket->id}",
                'type' => 'comment',
                'is_read' => 0,
            ]);
        }
        // ActivityLog::create([
        //     'ticket_id' => $ticket->id,
        //     'user_id' => auth()->id(),
        //     'action' => 'Comment Updated',
        //     'old_value' => $oldcomment,
        //     'new_value' => $request->comment
        // ]);



        $comment->save();
        return redirect()->route('customer.commentlist', $comment->ticket_id)->with('success', 'Updated');
    }

    public function show($id)
    {
        $ticket = Ticket::with('comments.user')->findOrFail($id);

        $comments = $ticket->comments;

        return view('customer.show', compact('ticket', 'comments'));
    }
}
