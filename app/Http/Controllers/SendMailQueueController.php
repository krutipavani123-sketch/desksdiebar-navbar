<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\sendmailqueue;
use Illuminate\Support\Facades\Mail;

class SendMailQueueController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->all();
        Mail::to($data["email"])->send(new sendmailqueue($data));

        return "Mail Send";
    }
}
