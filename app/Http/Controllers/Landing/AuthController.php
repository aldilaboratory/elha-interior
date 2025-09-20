<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        // Redirect landing/login ke /login
        return redirect()->to(route('login'));
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect(route('landing.login'))
                ->withErrors($validator)
                ->withInput();
        }

        $isAuth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'group_id' => 2
        ]);

        if (!$isAuth) {
            return redirect(route('landing.login'))
                ->withErrors(['auth_failed' => true])
                ->withInput();
        }

        return redirect()->to(route('shop'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->to(route('login'));
    }

    public function registrasi()
    {
        if (Auth::check()) {
            return redirect()->to(route('shop'));
        }
        return view('landing.registrasi');
    }
    public function setregistrasi(Request $request)
    {
        try {
            // validasi input
            $validated = $request->validate([
                'name'     => 'required|string|max:100',
                'phone'    => 'required|string|max:20|unique:user,phone',
                'email'    => 'required|email|unique:user,email',
                'password' => 'required|min:6',
                'alamat'   => 'required|string|max:255',
            ]);

            // simpan user baru
            $user = User::create([
                'name'     => $validated['name'],
                'phone'    => $validated['phone'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'alamat'   => $validated['alamat'],
                'group_id' => 2,
                'created_at' => Carbon::now()
            ]);

            // redirect ke halaman login dengan sweetalert
            return redirect()->route('landing.login')->with('sweetalert', [
                'type' => 'success',
                'title' => 'Registrasi Berhasil!',
                'text' => 'Akun Anda telah berhasil dibuat. Silakan login untuk melanjutkan.',
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }
}
