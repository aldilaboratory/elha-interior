<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilLengkapPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('landing.login')->with('message', 'Silakan login terlebih dahulu untuk mengakses profile.');
        }

        // Ambil user dengan relasi profile lengkap
        $user = Auth::user();
        $profiles = $user->profileLengkaps()->get();

        return view('landing.profile', compact('user', 'profiles'));
    }

    public function show()
    {
        // Alias untuk index method
        return $this->index();
    }

    public function update(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login terlebih dahulu.'
                ], 401);
            }
            return redirect()->route('landing.login')->with('message', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Validasi input
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => [
                    'required', 
                    'string', 
                    'max:255', 
                    'alpha_dash',
                    Rule::unique('user')->ignore($user->id)
                ],
                'email' => [
                    'required', 
                    'string', 
                    'email', 
                    'max:255',
                    Rule::unique('user')->ignore($user->id)
                ],
                'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
                'alamat' => ['nullable', 'string', 'max:500'],
            ], [
                'name.required' => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama lengkap maksimal 255 karakter.',
                'username.required' => 'Username wajib diisi.',
                'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash, dan underscore.',
                'username.unique' => 'Username sudah digunakan oleh pengguna lain.',
                'username.max' => 'Username maksimal 255 karakter.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
                'email.max' => 'Email maksimal 255 karakter.',
                'phone.max' => 'No. telepon maksimal 20 karakter.',
                'phone.regex' => 'Format no. telepon tidak valid. Gunakan angka, +, -, spasi, atau tanda kurung.',
                'alamat.max' => 'Alamat maksimal 500 karakter.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        try {
            // Update data user
            $user->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'alamat' => $validated['alamat'],
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profile berhasil diperbarui!',
                    'data' => [
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => $user->email,
                        'phone' => $user->phone,
                        'alamat' => $user->alamat,
                    ]
                ]);
            }

            return redirect()->route('landing.profile')
                ->with('success', 'Profile berhasil diperbarui!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui profile. Silakan coba lagi.'
                ], 500);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui profile. Silakan coba lagi.');
        }
    }

    public function changePassword(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $user = Auth::user();

        // Validasi input
        try {
            $validated = $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'min:6', 'confirmed'],
                'new_password_confirmation' => ['required'],
            ], [
                'current_password.required' => 'Password lama wajib diisi.',
                'new_password.required' => 'Password baru wajib diisi.',
                'new_password.min' => 'Password baru minimal 6 karakter.',
                'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
                'new_password_confirmation.required' => 'Konfirmasi password baru wajib diisi.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            // Cek apakah password lama benar
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak benar.'
                ], 422);
            }

            // Update password baru
            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.'
            ], 500);
        }
    }


}