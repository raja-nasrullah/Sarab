<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    // ✅ Fetch the initial message for the chat
    public function getChatMessages($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['messages' => []]);
        }

        // Format the user's message as a chat bubble
        $messages = [
            [
                'text' => $contact->message,
                'from' => 'them',
                'time' => date('M d, H:i', strtotime($contact->created_at))
            ]
        ];

        return response()->json(['messages' => $messages]);
    }

    // ✅ Send reply via Email (Does NOT save to DB)
        // ✅ Send reply via Email (Does NOT save to DB)
    public function sendReply(Request $request)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'message' => 'required|string'
        ]);

        $contact = Contact::find($request->contact_id);
        
        try {
            // Send actual PHP Email
            Mail::raw($request->message, function ($message) use ($contact) {
                $message->to($contact->email)
                        ->subject('Reply: ' . $contact->subject)
                        // ✅ FIX: Use the actual Gmail address from your .env
                        ->from(env('MAIL_FROM_ADDRESS'), 'Restaurant Admin')
                        // ✅ BONUS: Add a reply-to header to help inbox delivery
                        ->replyTo(env('MAIL_FROM_ADDRESS'), 'Restaurant Admin');
            });

            return response()->json([
                'success' => true,
                'time' => date('M d, H:i')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Mail error: ' . $e->getMessage()
            ], 500);
        }
    }
}