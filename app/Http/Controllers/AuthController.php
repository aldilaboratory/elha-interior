<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Redirect berdasarkan role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('landing.index');
            }
        }

        return view('auth.index');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('login'))
                ->withErrors($validator)
                ->withInput();
        }

        // Coba login tanpa filter group_id, biarkan role yang menentukan
        $isAuth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        if (!$isAuth) {
            return redirect(route('login'))
                ->withErrors(['auth_failed' => 'Email atau password salah']);
        }

        $user = Auth::user();
        
        // Redirect berdasarkan role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('landing.index');
        }
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->to(route('login'));
    }
}
