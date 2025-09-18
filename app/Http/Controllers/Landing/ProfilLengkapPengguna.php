<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ProfilLengkapPengguna as ModelProfileLengkapPengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilLengkapPengguna extends Controller
{
    public function index()
    {
        $profiles = ModelProfileLengkapPengguna::where("user_id", Auth::id())->get();
        return view("landing.profile-pengguna", compact("profiles"));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name_penerima" => "required|string|max:255",
            "alamat" => "required|string",
            "no_telp" => "required|string|max:20",
            "provinsi_id" => "required|integer",
            "provinsi_nama" => "required|string|max:255",
            "kota_id" => "required|integer",
            "kota_nama" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        try {
            ModelProfileLengkapPengguna::create([
                "user_id" => Auth::id(),
                "name_penerima" => $request->name_penerima,
                "alamat" => $request->alamat,
                "no_telp" => $request->no_telp,
                "provinsi_id" => $request->provinsi_id,
                "provinsi_nama" => $request->provinsi_nama,
                "kota_id" => $request->kota_id,
                "kota_nama" => $request->kota_nama,
            ]);

            return response()->json([
                "success" => true,
                "message" => "Profil berhasil ditambahkan",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Terjadi kesalahan: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function show($id)
    {
        $profile = ModelProfileLengkapPengguna::where("id", $id)
            ->where("user_id", Auth::id())
            ->first();

        if (!$profile) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Profil tidak ditemukan",
                ],
                404,
            );
        }

        return response()->json([
            "success" => true,
            "data" => $profile,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name_penerima" => "required|string|max:255",
            "alamat" => "required|string",
            "no_telp" => "required|string|max:20",
            "provinsi_id" => "required|integer",
            "provinsi_nama" => "required|string|max:255",
            "kota_id" => "required|integer",
            "kota_nama" => "required|string|max:255",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Validation failed",
                    "errors" => $validator->errors(),
                ],
                422,
            );
        }

        $profile = ModelProfileLengkapPengguna::where("id", $id)
            ->where("user_id", Auth::id())
            ->first();

        if (!$profile) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Profil tidak ditemukan",
                ],
                404,
            );
        }

        try {
            $profile->update([
                "name_penerima" => $request->name_penerima,
                "alamat" => $request->alamat,
                "no_telp" => $request->no_telp,
                "provinsi_id" => $request->provinsi_id,
                "provinsi_nama" => $request->provinsi_nama,
                "kota_id" => $request->kota_id,
                "kota_nama" => $request->kota_nama,
            ]);

            return response()->json([
                "success" => true,
                "message" => "Profil berhasil diupdate",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Terjadi kesalahan: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id)
    {
        $profile = ModelProfileLengkapPengguna::where("id", $id)
            ->where("user_id", Auth::id())
            ->first();

        if (!$profile) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Profil tidak ditemukan",
                ],
                404,
            );
        }

        try {
            $profile->delete();

            return response()->json([
                "success" => true,
                "message" => "Profil berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Terjadi kesalahan: " . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
