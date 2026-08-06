<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user')) {
            return redirect('/login');
        }

        if (Session::get('user.role') !== 'User') {
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}