<?php

namespace App\Http\Controllers;

use App\Models\InfoPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class InfoPromosiController extends Controller
{
    public function edit($id)
    {
        $infoPromosi = InfoPromosi::where("id", $id)->first();
        if (!$infoPromosi) {
            return abort(404);
        }

        return view("administrator.infopromosi.edit", [
            "infoPromosi" => $infoPromosi
        ]);
    }


    public function update(Request $request, $id)
    {
        $infoPromosi = InfoPromosi::find($id);
        if (!$infoPromosi) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
            "image"       => "nullable|image|mimes:jpg,jpeg,png", // Boleh kosong saat update
        ]);

        if ($validator->fails()) {
            return redirect(route("infopromosi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file jika ada
        $fileName = $infoPromosi->image; // default: pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/infopromosi
            $destination = public_path('upload/infopromosi');
            
            // Buat folder jika belum ada
            if (!is_dir($destination)) {
                mkdir($destination, 0755, true);
            }
            
            $file->move($destination, $fileName);

            // Hapus file lama jika ada
            if ($infoPromosi->image && file_exists($destination . '/' . $infoPromosi->image)) {
                @unlink($destination . '/' . $infoPromosi->image);
            }
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
            "image"       => $fileName,
        ];

        try {
            $infoPromosi->update($dataSave);
            return redirect(route("infopromosi.edit", $id))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("infopromosi.edit", $id))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }
}
