<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Dërgo email
        Mail::raw("
            From: {$validated['name']} ({$validated['email']})\n
            Subject: {$validated['subject']}\n
            Message:\n{$validated['message']}
        ", function ($msg) use ($validated) {
            $msg->to('leart.bytyqii98@gmail.com')
                ->subject('New Contact Message: ' . $validated['subject']);
        });

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}
