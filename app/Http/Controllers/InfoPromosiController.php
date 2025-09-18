<?php

namespace App\Http\Controllers;

use App\Models\InfoPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class InfoPromosiController extends Controller
{
    public function edit($id)
    {
        $infoPromosi = InfoPromosi::where("id", $id)->first();
        if (!$infoPromosi) {
            return abort(404);
        }

        return view("administrator.infopromosi.edit", [
            "infoPromosi" => $infoPromosi
        ]);
    }


    public function update(Request $request, $id)
    {
        $infoPromosi = InfoPromosi::find($id);
        if (!$infoPromosi) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            "nama"        => "required",
            "deskripsi"   => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("infopromosi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        // Data yang akan disimpan
        $dataSave = [
            "nama"        => $request->input("nama"),
            "deskripsi"   => $request->input("deskripsi"),
        ];

        try {
            $infoPromosi->update($dataSave);
            return redirect(route("infopromosi.edit", $id))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("infopromosi.edit", $id))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }
}
