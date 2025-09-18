<?php

namespace App\Http\Controllers;

use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class TransaksiDetailController extends Controller
{
    public function index()
    {
        return view("administrator.transaksi_detail.index");
    }

    public function create()
    {
        return view("administrator.transaksi_detail.create");
    }

    public function edit($id)
    {
        $transaksiDetail = TransaksiDetail::where("id", $id)->first();
        if (!$transaksiDetail) {
            return abort(404);
        }

        return view("administrator.transaksi_detail.edit", [
            "transaksi_detail" => $transaksiDetail,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "transaksi_id" => "required",
            "produk_id" => "required",
            "harga" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("transaksi_detail.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "transaksi_id" => $request->input("transaksi_id"),
            "produk_id" => $request->input("produk_id"),
            "harga" => $request->input("harga"),
        ];

        try {
            TransaksiDetail::create($dataSave);
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $transaksiDetail = TransaksiDetail::query();

        return DataTables::of($transaksiDetail)->addIndexColumn()->make(true);
    }

    public function update(Request $request, $id)
    {
        $transaksiDetail = TransaksiDetail::where("id", $id)->first();
        if (!$transaksiDetail) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "transaksi_id" => "required",
            "produk_id" => "required",
            "harga" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("transaksi_detail.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "transaksi_id" => $request->input("transaksi_id"),
            "produk_id" => $request->input("produk_id"),
            "harga" => $request->input("harga"),
        ];

        try {
            $transaksiDetail->update($dataSave);
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $transaksiDetail = TransaksiDetail::where("id", $id)->first();
        if (!$transaksiDetail) {
            return abort(404);
        }

        try {
            $transaksiDetail->delete();
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi_detail.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
}
