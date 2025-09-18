<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class DesaController extends Controller
{
    public function index()
    {
        return view("administrator.desa.index");
    }

    public function create()
    {
        return view("administrator.desa.create");
    }

    public function edit($id)
    {
        $desa = Desa::where("id", $id)->first();
        if (!$desa) {
            return abort(404);
        }

        return view("administrator.desa.edit", [
            "desa" => $desa,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kecamatan_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("desa.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kecamatan_id" => $request->input("kecamatan_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            Desa::create($dataSave);
            return redirect(route("desa.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("desa.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $desa = Desa::query();

        return DataTables::of($desa)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $desa = Desa::where("id", $id)->first();
        if (!$desa) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "kecamatan_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("desa.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kecamatan_id" => $request->input("kecamatan_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            $desa->update($dataSave);
            return redirect(route("desa.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("desa.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $desa = Desa::where("id", $id)->first();
        if (!$desa) {
            return abort(404);
        }

        try {
            $desa->delete();
            return redirect(route("desa.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("desa.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
