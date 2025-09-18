<?php

namespace App\Http\Controllers;

use App\Models\Ekspedisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class EkspedisiController extends Controller
{
    public function index()
    {
        return view("administrator.ekspedisi.index");
    }

    public function create()
    {
        return view("administrator.ekspedisi.create");
    }

    public function edit($id)
    {
        $ekspedisi = Ekspedisi::where("id", $id)->first();
        if (!$ekspedisi) {
            return abort(404);
        }

        return view("administrator.ekspedisi.edit", [
            "ekspedisi" => $ekspedisi,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kode" => "required",
            "nama" => "required",
            "image" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("ekspedisi.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kode" => $request->input("kode"),
            "nama" => $request->input("nama"),
            "image" => $request->input("image"),
        ];

        try {
            Ekspedisi::create($dataSave);
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $ekspedisi = Ekspedisi::query();

        return DataTables::of($ekspedisi)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $ekspedisi = Ekspedisi::where("id", $id)->first();
        if (!$ekspedisi) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "kode" => "required",
            "nama" => "required",
            "image" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("ekspedisi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "kode" => $request->input("kode"),
            "nama" => $request->input("nama"),
            "image" => $request->input("image"),
        ];

        try {
            $ekspedisi->update($dataSave);
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $ekspedisi = Ekspedisi::where("id", $id)->first();
        if (!$ekspedisi) {
            return abort(404);
        }

        try {
            $ekspedisi->delete();
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("ekspedisi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
