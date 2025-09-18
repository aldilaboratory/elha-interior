<?php

namespace App\Http\Controllers;

use App\Models\Metode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class MetodeController extends Controller
{
    public function index()
    {
        return view("administrator.metode.index");
    }

    public function create()
    {
        return view("administrator.metode.create");
    }

    public function edit($id)
    {
        $metode = Metode::where("id", $id)->first();
        if (!$metode) {
            return abort(404);
        }

        return view("administrator.metode.edit", [
            "metode" => $metode,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("metode.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            Metode::create($dataSave);
            return redirect(route("metode.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("metode.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $metode = Metode::query();

        return DataTables::of($metode)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $metode = Metode::where("id", $id)->first();
        if (!$metode) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), ["nama" => "required"]);

        if ($validator->fails()) {
            return redirect(route("metode.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = ["nama" => $request->input("nama")];

        try {
            $metode->update($dataSave);
            return redirect(route("metode.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("metode.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $metode = Metode::where("id", $id)->first();
        if (!$metode) {
            return abort(404);
        }

        try {
            $metode->delete();
            return redirect(route("metode.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("metode.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
