<?php

namespace App\Http\Controllers;

use App\Models\ProdukBaruPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class ProdukBaruPromosiController extends Controller
{
    public function edit($id)
    {
        $produkbaruPromosi = ProdukBaruPromosi::where("id", $id)->first();
        if (!$produkbaruPromosi) {
            return abort(404);
        }
        $produk = Produk::all();

        return view("administrator.produkbarupromosi.edit", [
            "produk" => $produk,
            "produkbaruPromosi" => $produkbaruPromosi
        ]);
    }


    public function update(Request $request, $id)
    {
        $produkbaruPromosi = ProdukBaruPromosi::find($id);
        if (!$produkbaruPromosi) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
            "image"       => "nullable|image|mimes:jpg,jpeg,png", // Boleh kosong saat update
        ]);

        if ($validator->fails()) {
            return redirect(route("produkbaru.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file jika ada
        $fileName = $produkbaruPromosi->image; // default: pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/produk
            $destination = base_path('../public_html/upload/produkbarupromosi');
            $file->move($destination, $fileName);

            // Hapus file lama jika ada
            if ($produkbaruPromosi->image && file_exists($destination . $produkbaruPromosi->image)) {
                @unlink($destination . $produkbaruPromosi->image);
            }
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
            "image"       => $fileName,

        ];

        try {
            $produkbaruPromosi->update($dataSave);
            return redirect(route("produkbaru.edit", $id))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("produkbaru.edit", $id))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }
}
