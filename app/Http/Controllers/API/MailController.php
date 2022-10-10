<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request){
        $mailData = [
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message')
            ];
    
        $fromSender = $request->input('email');
        Mail::send('email.test', ['mailData' => $mailData], function ($m) use ($fromSender) {
        
            $m->from($fromSender)->to('mail@igwt-consulting.com')->subject('Message Inquiry!');
    });
    return response()->json(["status"=>200,"message" => "Email sent successfully."]);
    }

    
}
