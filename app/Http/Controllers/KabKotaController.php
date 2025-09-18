<?php

namespace App\Http\Controllers;

use App\Models\KabKota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class KabKotaController extends Controller
{
    public function index()
    {
        return view("administrator.kab_kota.index");
    }

    public function create()
    {
        return view("administrator.kab_kota.create");
    }

    public function edit($id)
    {
        $kabKota = KabKota::where("id", $id)->first();
        if (!$kabKota) {
            return abort(404);
        }

        return view("administrator.kab_kota.edit", [
            "kab_kota" => $kabKota,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "provinsi_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("kab_kota.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "provinsi_id" => $request->input("provinsi_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            KabKota::create($dataSave);
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $kabKota = KabKota::query();

        return DataTables::of($kabKota)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $kabKota = KabKota::where("id", $id)->first();
        if (!$kabKota) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "provinsi_id" => "required",
            "nama" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("kab_kota.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "provinsi_id" => $request->input("provinsi_id"),
            "nama" => $request->input("nama"),
        ];

        try {
            $kabKota->update($dataSave);
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $kabKota = KabKota::where("id", $id)->first();
        if (!$kabKota) {
            return abort(404);
        }

        try {
            $kabKota->delete();
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("kab_kota.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
