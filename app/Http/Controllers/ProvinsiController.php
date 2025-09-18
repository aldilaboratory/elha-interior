<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    public function index()
    {
        return view("administrator.provinsi.index");
    }

    public function create()
    {
        return view("administrator.provinsi.create");
    }

    public function edit($id)
    {
        $provinsi = Provinsi::where("id", $id)->first();
        if (!$provinsi) {
            return abort(404);
        }

        return view("administrator.provinsi.edit", [
            "provinsi" => $provinsi,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("provinsi.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            Provinsi::create($dataSave);
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $provinsi = Provinsi::query();

        return DataTables::of($provinsi)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $provinsi = Provinsi::where("id", $id)->first();
        if (!$provinsi) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("provinsi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            $provinsi->update($dataSave);
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $provinsi = Provinsi::where("id", $id)->first();
        if (!$provinsi) {
            return abort(404);
        }

        try {
            $provinsi->delete();
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("provinsi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
