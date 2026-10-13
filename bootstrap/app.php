<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException; // ✅ Added this import

// use Illuminate\Cache\RateLimiting\Limit;
// use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // ✅ ADD THIS ONE LINE RIGHT HERE:
        // This applies a limit of 60 requests per minute to ALL routes in api.php
        $middleware->api('throttle:60,1'); 
        


        //======This is Second Method =========
        //  RateLimiter::for('api', function ($job) {
        //     return Limit::perMinute(60)->by($job->user()?->id ?: $job->ip());
        // });


        // Your existing middleware aliases (Keep these as they are)
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ✅ ADDED THIS BLOCK TO STOP HTML REDIRECTS FOR API REQUESTS
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please provide a valid Bearer Token.'
                ], 401);
            }
        });
    })
    ->create();