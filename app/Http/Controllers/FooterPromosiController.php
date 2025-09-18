<?php

namespace App\Http\Controllers;

use App\Models\FooterPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class FooterPromosiController extends Controller
{
    public function index()
    {
        return view("administrator.footerpromosi.index");
    }

    public function edit($id)
    {
        $footerPromosi = FooterPromosi::where("id", $id)->first();
        if (!$footerPromosi) {
            return abort(404);
        }
        $produk = Produk::all();

        return view("administrator.footerpromosi.edit", [
            "produk" => $produk,
            "footerPromosi" => $footerPromosi
        ]);
    }

    public function fetch(Request $request)
    {
        $produk = FooterPromosi::join('produk', 'produk.id', '=', 'footer_promosi.produk_id')
            ->select('footer_promosi.*', 'produk.nama as produk_nama')
            ->get();

        return DataTables::of($produk)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $footerPromosi = FooterPromosi::find($id);
        if (!$footerPromosi) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
            "image"       => "nullable|image|mimes:jpg,jpeg,png", // Boleh kosong saat update
            "produk_id" => "required|exists:produk,id",
        ]);

        if ($validator->fails()) {
            return redirect(route("footerpromosi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file jika ada
        $fileName = $footerPromosi->image; // default: pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/produk
            $destination = base_path('../public_html/upload/footerpromosi');
            $file->move($destination, $fileName);

            // Hapus file lama jika ada
            if ($footerPromosi->image && file_exists($destination . $footerPromosi->image)) {
                @unlink($destination . $footerPromosi->image);
            }
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
            "image"       => $fileName,
            "produk_id" => $request->input("produk_id"),

        ];

        try {
            $footerPromosi->update($dataSave);
            return redirect(route("footerpromosi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("footerpromosi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $footerPromosi = FooterPromosi::find($id);
        if (!$footerPromosi) {
            return abort(404);
        }

        try {
            $footerPromosi->delete();
            return redirect(route("footerpromosi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("footerpromosi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
