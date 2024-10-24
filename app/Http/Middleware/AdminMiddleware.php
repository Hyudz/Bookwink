<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has user_type as 'admin'
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return $next($request); // User is an admin, allow access
        }

        // Redirect non-admin users to the home page or another appropriate location
        return redirect('/'); 
    }
}
