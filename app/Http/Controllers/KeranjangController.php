<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class KeranjangController extends Controller
{
    public function index()
    {
        return view("administrator.keranjang.index");
    }

    public function create()
    {
        return view("administrator.keranjang.create");
    }

    public function edit($id)
    {
        $keranjang = Keranjang::where("id", $id)->first();
        if (!$keranjang) {
            return abort(404);
        }

        return view("administrator.keranjang.edit", [
            "keranjang" => $keranjang,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return redirect(route("keranjang.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [];

        try {
            Keranjang::create($dataSave);
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $keranjang = Keranjang::query();

        return DataTables::of($keranjang)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::where("id", $id)->first();
        if (!$keranjang) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return redirect(route("keranjang.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [];

        try {
            $keranjang->update($dataSave);
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::where("id", $id)->first();
        if (!$keranjang) {
            return abort(404);
        }

        try {
            $keranjang->delete();
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("keranjang.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
