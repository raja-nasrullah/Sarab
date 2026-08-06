<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Check if user is logged in
        if (!Session::has('user')) {
            // 🛑 CRITICAL: If it's an AJAX request, don't redirect to HTML login page. Return JSON error instead.
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unauthenticated. Please refresh and login again.'], 401);
            }
            return redirect('/login');
        }

        // 2. Check if the user is an Administrator
        if (Session::get('user.role') !== 'Administrator') {
            // 🛑 CRITICAL: If it's an AJAX request, return JSON error instead of redirecting to HTML.
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Forbidden. Admin access only.'], 403);
            }
            return redirect('/user/dashboard');
        }

        return $next($request);
    }
}