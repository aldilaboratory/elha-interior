<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
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
            
            // Redirect admin to admin dashboard if they try to access landing pages
            if ($user->isAdmin() && $request->is('landing/*')) {
                return redirect()->route('admin.dashboard');
            }
            
            // Redirect customer to landing if they try to access admin pages
            if ($user->isCustomer() && $request->is('admin/*')) {
                return redirect()->route('landing.index');
            }
        }
        
        return $next($request);
    }
}
