<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole(['admin', 'agent'])) {
                return $next($request);
            }
            Auth::logout();
            return redirect()->route('login')->with('error', "You have been logout because you don't have permission to access this page!!");
        }
        return redirect()->route('login')->with('error', 'Please login to access this page');
    }
}
