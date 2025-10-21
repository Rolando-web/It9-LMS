<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // Check if the user is authenticated
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Please login to access this area.');
    }

    // Get the authenticated user
    $user = Auth::user();

    // Check if the user has 'user' role (regular user, not admin or super_admin)
    if (!$user || $user->role !== 'user') {
      abort(403, 'Unauthorized access. This area is for regular users only.');
    }

    return $next($request);
  }
}
