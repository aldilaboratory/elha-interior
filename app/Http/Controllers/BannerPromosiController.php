<?php

namespace App\Http\Controllers;

use App\Models\BannerPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Yajra\DataTables\Facades\DataTables;

class BannerPromosiController extends Controller
{
    public function index()
    {
        return view("administrator.bannerpromosi.index");
    }

    public function create()
    {
        $produk = Produk::all();
        return view("administrator.bannerpromosi.create", compact('produk'));
    }

    public function edit($id)
    {
        $bannerPromosi = BannerPromosi::where("id", $id)->first();
        if (!$bannerPromosi) {
            return abort(404);
        }
        $produk = Produk::all();

        return view("administrator.bannerpromosi.edit", [
            "produk" => $produk,
            "bannerPromosi" => $bannerPromosi
        ]);
    }

    public function store(Request $request)
    {
        Log::info('Banner promosi store request received', [
            'method' => $request->method(),
            'has_file' => $request->hasFile('image'),
            'all_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            "nama" => "required",
            "deskripsi" => "required",
            "image" => "required|image|mimes:jpg,jpeg,png",
        ]);

        if ($validator->fails()) {
            Log::error('Banner promosi validation failed', $validator->errors()->toArray());
            return redirect(route("bannerpromosi.create"))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file
        $fileName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('File details', [
                'name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType(),
                'is_valid' => $file->isValid()
            ]);

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            Log::info('Generated filename: ' . $fileName);

            // Pindahkan ke folder public/upload/bannerpromosi
            $destination = public_path('upload/bannerpromosi');
            Log::info('Upload destination: ' . $destination);
            
            if (!is_dir($destination)) {
                Log::info('Creating directory: ' . $destination);
                mkdir($destination, 0755, true);
            }
            
            $file->move($destination, $fileName);
            Log::info('File uploaded successfully to: ' . $destination . '/' . $fileName);
        } else {
            Log::error('No file received in request');
        }

        // Simpan ke database
        $dataSave = [
            "nama" => $request->input("nama"),
            "deskripsi" => $request->input("deskripsi"),
            "image" => $fileName,
        ];

        try {
            Log::info('Saving banner promosi data', $dataSave);
            BannerPromosi::create($dataSave);
            Log::info('Banner promosi saved successfully');
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            Log::error('Error saving banner promosi: ' . $th->getMessage());
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $bannerPromosi = BannerPromosi::all();

        return DataTables::of($bannerPromosi)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $bannerPromosi = BannerPromosi::find($id);
        if (!$bannerPromosi) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
            "image"       => "nullable|image|mimes:jpg,jpeg,png", // Boleh kosong saat update
        ]);

        if ($validator->fails()) {
            return redirect(route("bannerpromosi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file jika ada
        $fileName = $bannerPromosi->image; // default: pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/bannerpromosi
            $destination = public_path('upload/bannerpromosi');
            $file->move($destination, $fileName);

            // Hapus file lama jika ada
            if ($bannerPromosi->image && file_exists($destination . '/' . $bannerPromosi->image)) {
                @unlink($destination . '/' . $bannerPromosi->image);
            }
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
            "image"       => $fileName,

        ];

        try {
            $bannerPromosi->update($dataSave);
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $bannerPromosi = BannerPromosi::where("id", $id)->first();
        if (!$bannerPromosi) {
            return abort(404);
        }

        try {
            $bannerPromosi->delete();
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("bannerpromosi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
