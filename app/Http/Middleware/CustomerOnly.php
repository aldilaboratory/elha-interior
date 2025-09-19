<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah login
        if (Auth::check()) {
            $user = Auth::user();
            
            // Jika user adalah admin (group_id = 1), redirect ke dashboard admin
            if ($user->group_id == 1) {
                return redirect()->route('dashboard')->with('error', 'Admin tidak dapat mengakses halaman ini. Silakan gunakan panel admin.');
            }
        } else {
            // Jika user belum login, redirect ke halaman login
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}