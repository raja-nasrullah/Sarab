<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminIndex()
{
    $users = \App\Models\User::select('id', 'name', 'email', 'created_at')->orderBy('created_at', 'desc')->get();
    return view('admin.pages.user.user', compact('users'));
}
    public function index()
    {
        // We only get id, name, and email. We skip 'password' to avoid crash!
        $users = \App\Models\User::select('id', 'name', 'email', 'created_at')->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
