<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect('/login'); // Redirect to login if not logged in
        }

        // Check if the user is an admin
        if (auth()->user()->role !== 'admin') {
            return redirect('/home'); // Redirect to home if not an admin
        }
        return $next($request);
    }
}
