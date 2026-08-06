<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // ✅ FIXED: This method handles both the HTML View AND the JSON API request
    // Inside app/Http/Controllers/ContactController.php

    public function adminIndex(Request $request)
    {
        $contacts = Contact::orderBy('created_at', 'desc')->get();
        
        // ✅ CRITICAL FIX: If the request wants JSON (like the Chat page), return JSON.
        if ($request->wantsJson()) {
            return response()->json($contacts);
        }
        
        // Otherwise, return the normal Admin Contacts HTML View
        return view('admin.pages.contacts', compact('contacts'));
    }

    // ✅ API: Get all contacts (For general API use if needed)
    public function index()
    {
        return response()->json(Contact::all());
    }

    // ✅ API: Store a new contact (used by the public website)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    // ✅ API: Show a single contact
    public function show($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }
        return response()->json($contact);
    }

    // ✅ API: Update a contact
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'sometimes|string|max:255',
            'message' => 'sometimes|string',
        ]);

        $contact->update($request->all());
        return response()->json($contact);
    }

    // ✅ API: Delete a contact
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();
        return response()->json(['message' => 'Contact deleted successfully']);
    }
}