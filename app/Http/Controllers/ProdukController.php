<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index()
    {
        return view("administrator.produk.index");
    }

    public function create()
    {
        $dataKategori = Kategori::all();
        return view("administrator.produk.create", compact('dataKategori'));
    }

    public function edit($id)
    {
        $produk = Produk::where("id", $id)->first();
        if (!$produk) {
            return abort(404);
        }
        $dataKategori = Kategori::all();

        return view("administrator.produk.edit", [
            "produk" => $produk,
            "dataKategori" => $dataKategori
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "nama" => "required",
            "deskripsi" => "required",
            "image" => "required|image|mimes:jpg,jpeg,png",
            "harga" => "required|numeric|min:0",
            "berat" => "nullable|numeric|min:0",
            "kategori_id" => "required|exists:kategori,id",
        ]);

        if ($validator->fails()) {
            return redirect(route("produk.create"))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file
        $fileName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/produk
            $destination = public_path('upload/produk');
            $file->move($destination, $fileName);
        }

        // Simpan ke database
        $dataSave = [
            "nama" => $request->input("nama"),
            "deskripsi" => $request->input("deskripsi"),
            "image" => $fileName,
            "harga" => $request->input("harga"),
            "kategori_id" => $request->input("kategori_id"),
            "berat" => $request->input("berat"),
        ];

        try {
            Produk::create($dataSave);
            return redirect(route("produk.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("produk.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $produk = Produk::join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.nama as kategori_nama')
            ->get();

        return DataTables::of($produk)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
            "image"       => "nullable|image|mimes:jpg,jpeg,png", // Boleh kosong saat update
            "harga"       => "required|numeric|min:0",
            "berat"       => "nullable|numeric|min:0",
            "kategori_id" => "required|exists:kategori,id",
        ]);

        if ($validator->fails()) {
            return redirect(route("produk.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Upload file jika ada
        $fileName = $produk->image; // default: pakai gambar lama
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Buat nama random + extension
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/upload/produk
            $destination = public_path('upload/produk');
            $file->move($destination, $fileName);

            // Hapus file lama jika ada
            if ($produk->image && file_exists($destination . '/' . $produk->image)) {
                @unlink($destination . '/' . $produk->image);
            }
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
            "image"       => $fileName,
            "harga"       => $request->input("harga"),
            "kategori_id" => $request->input("kategori_id"),
            "berat" => $request->input("berat"),
        ];

        try {
            $produk->update($dataSave);
            return redirect(route("produk.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("produk.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $produk = Produk::where("id", $id)->first();
        if (!$produk) {
            return abort(404);
        }

        try {
            $produk->delete();
            return redirect(route("produk.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("produk.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
