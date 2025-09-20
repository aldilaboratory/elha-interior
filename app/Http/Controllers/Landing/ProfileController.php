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

            return redirect()->route('landing.profile-pengguna')
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

    /**
     * Store a new address
     */
    public function storeAddress(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $validated = $request->validate([
                'name_penerima' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:1000'],
                'no_telp' => ['required', 'string', 'max:20'],
                'provinsi_id' => ['required', 'integer'],
                'provinsi_nama' => ['required', 'string', 'max:255'],
                'kota_id' => ['required', 'integer'],
                'kota_nama' => ['required', 'string', 'max:255'],
            ], [
                'name_penerima.required' => 'Nama penerima wajib diisi.',
                'alamat.required' => 'Alamat wajib diisi.',
                'no_telp.required' => 'No. telepon wajib diisi.',
                'provinsi_id.required' => 'Provinsi wajib dipilih.',
                'kota_id.required' => 'Kota wajib dipilih.',
            ]);

            $validated['user_id'] = Auth::id();
            
            // If this is the first address, make it default
            $existingAddresses = ProfilLengkapPengguna::where('user_id', Auth::id())->count();
            if ($existingAddresses == 0) {
                $validated['is_default'] = true;
            }

            $address = ProfilLengkapPengguna::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil ditambahkan!',
                'data' => $address
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambah alamat.'
            ], 500);
        }
    }

    /**
     * Update an address
     */
    public function updateAddress(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $address = ProfilLengkapPengguna::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validate([
                'name_penerima' => ['required', 'string', 'max:255'],
                'alamat' => ['required', 'string', 'max:1000'],
                'no_telp' => ['required', 'string', 'max:20'],
                'provinsi_id' => ['required', 'integer'],
                'provinsi_nama' => ['required', 'string', 'max:255'],
                'kota_id' => ['required', 'integer'],
                'kota_nama' => ['required', 'string', 'max:255'],
            ]);

            $address->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil diperbarui!',
                'data' => $address
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui alamat.'
            ], 500);
        }
    }

    /**
     * Delete an address
     */
    public function deleteAddress($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $address = ProfilLengkapPengguna::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Check if this is the default address
            $isDefault = $address->is_default;
            
            $address->delete();

            // If deleted address was default, set another address as default
            if ($isDefault) {
                $newDefault = ProfilLengkapPengguna::where('user_id', Auth::id())->first();
                if ($newDefault) {
                    $newDefault->setAsDefault();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dihapus!'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus alamat.'
            ], 500);
        }
    }

    /**
     * Set address as default
     */
    public function setDefaultAddress($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $address = ProfilLengkapPengguna::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $address->setAsDefault();

            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dijadikan alamat default!'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengatur alamat default.'
            ], 500);
        }
    }

    /**
     * Get address details
     */
    public function getAddress($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        try {
            $address = ProfilLengkapPengguna::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return response()->json([
                'success' => true,
                'data' => $address
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data alamat.'
            ], 500);
        }
    }
}