<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ChatController extends Controller
{
    // Display the Chat page
    public function index()
    {
        // Fetch the contacts directly from the database
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        
        // Pass them directly to the view
        return view('admin.pages.chat', compact('contacts'));
    }
}