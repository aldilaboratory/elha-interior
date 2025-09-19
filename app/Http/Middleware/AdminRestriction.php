<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminRestriction
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
        // Jika user sudah login dan adalah admin
        if (Auth::check() && Auth::user()->group_id == 1) {
            $currentPath = $request->path();
            
            // Daftar path yang diizinkan untuk admin
            $allowedPaths = [
                'login',
                'logout', 
                'authenticate',
                'admin',
                'admin/*'
            ];
            
            // Cek apakah path saat ini diizinkan untuk admin
            $isAllowed = false;
            foreach ($allowedPaths as $allowedPath) {
                if ($allowedPath === $currentPath || 
                    (str_ends_with($allowedPath, '/*') && str_starts_with($currentPath, rtrim($allowedPath, '/*')))) {
                    $isAllowed = true;
                    break;
                }
            }
            
            // Jika path tidak diizinkan, redirect ke dashboard admin
            if (!$isAllowed) {
                return redirect()->route('dashboard')->with('error', 'Admin hanya dapat mengakses panel admin. Akses ke halaman pelanggan dibatasi.');
            }
        }

        return $next($request);
    }
}