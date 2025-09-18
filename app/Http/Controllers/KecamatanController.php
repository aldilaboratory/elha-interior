<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class KecamatanController extends Controller
{
    public function index()
    {
        return view("administrator.kecamatan.index");
    }

    public function create()
    {
        return view("administrator.kecamatan.create");
    }

    public function edit($id)
    {
        $kecamatan = Kecamatan::where("id", $id)->first();
        if (!$kecamatan) {
            return abort(404);
        }

        return view("administrator.kecamatan.edit", [
            "kecamatan" => $kecamatan,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kab_kot_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("kecamatan.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kab_kot_id" => $request->input("kab_kot_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            Kecamatan::create($dataSave);
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $kecamatan = Kecamatan::query();

        return DataTables::of($kecamatan)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $kecamatan = Kecamatan::where("id", $id)->first();
        if (!$kecamatan) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "kab_kot_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("kecamatan.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kab_kot_id" => $request->input("kab_kot_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            $kecamatan->update($dataSave);
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $kecamatan = Kecamatan::where("id", $id)->first();
        if (!$kecamatan) {
            return abort(404);
        }

        try {
            $kecamatan->delete();
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kecamatan.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
