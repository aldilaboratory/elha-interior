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
            return redirect()->to(route('dashboard'));
        }

        return view('auth.index');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('login'))
                ->withErrors($validator)
                ->withInput();
        }

        $isAuth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'group_id' => 1
        ]);

        if (!$isAuth) {
            return redirect(route('login'))
                ->withErrors(['auth_failed' => true]);
        }

        return redirect()->to(route('dashboard'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->to(route('login'));
    }
}
