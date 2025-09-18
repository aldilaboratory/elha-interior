<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        return view("administrator.kategori.index");
    }

    public function create()
    {
        return view("administrator.kategori.create");
    }

    public function edit($id)
    {
        $kategori = Kategori::where("id", $id)->first();
        if (!$kategori) {
            return abort(404);
        }

        return view("administrator.kategori.edit", [
            "kategori" => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("kategori.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            Kategori::create($dataSave);
            return redirect(route("kategori.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kategori.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $kategori = Kategori::query();

        return DataTables::of($kategori)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::where("id", $id)->first();
        if (!$kategori) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("kategori.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            $kategori->update($dataSave);
            return redirect(route("kategori.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kategori.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $kategori = Kategori::where("id", $id)->first();
        if (!$kategori) {
            return abort(404);
        }

        try {
            $kategori->delete();
            return redirect(route("kategori.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kategori.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
