<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        return view("administrator.transaksi.index");
    }

    public function create()
    {
        return view("administrator.transaksi.create");
    }

    public function edit($id)
    {
        $transaksi = Transaksi::where("id", $id)->first();
        if (!$transaksi) {
            return abort(404);
        }

        return view("administrator.transaksi.edit", [
            "transaksi" => $transaksi,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "total_harga" => "required",
            "metode_id" => "required",
            "ekspedisi_id" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("transaksi.create"))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "user_id" => $request->input("user_id"),
            "total_harga" => $request->input("total_harga"),
            "metode_id" => $request->input("metode_id"),
            "ekspedisi_id" => $request->input("ekspedisi_id"),
        ];

        try {
            Transaksi::create($dataSave);
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil disimpan",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menyimpan data",
            ]);
        }
    }

    public function fetch(Request $request)
    {
        $transaksi = DB::table('transaksi')
            ->join('user', 'user.id', '=', 'transaksi.user_id')
            ->join('transaksi_detail', 'transaksi_detail.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'produk.id', '=', 'transaksi_detail.produk_id')
            ->select(
                'transaksi.id',
                'transaksi.ongkir as ongkir',
                'transaksi.nama_penerima as nama_penerima',
                'transaksi.status as status',
                'transaksi.total as total',
                'transaksi.paket_estimasi as estimasi',
                'transaksi.resi as resi',
                'user.name as nama_user',
                DB::raw('GROUP_CONCAT(produk.nama SEPARATOR ", ") as daftar_produk'),
                'transaksi.created_at'
            )
            ->groupBy('transaksi.id', 'transaksi.ongkir', 'transaksi.status', 'transaksi.total', 'nama_penerima' ,'transaksi.paket_estimasi', 'transaksi.resi', 'user.name', 'transaksi.created_at');

        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::where("id", $id)->first();
        if (!$transaksi) {
            return abort(404);
        }

        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "total_harga" => "required",
            "metode_id" => "required",
            "ekspedisi_id" => "required",
        ]);

        if ($validator->fails()) {
            return redirect(route("transaksi.edit", $id))
                ->withErrors($validator)
                ->withInput();
        }

        $dataSave = [
            "user_id" => $request->input("user_id"),
            "total_harga" => $request->input("total_harga"),
            "metode_id" => $request->input("metode_id"),
            "ekspedisi_id" => $request->input("ekspedisi_id"),
        ];

        try {
            $transaksi->update($dataSave);
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil diupdate",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat mengupdate data",
            ]);
        }
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::where("id", $id)->first();
        if (!$transaksi) {
            return abort(404);
        }

        try {
            $transaksi->delete();
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => true,
                "message" => "Data berhasil dihapus",
            ]);
        } catch (\Throwable $th) {
            return redirect(route("transaksi.index"))->with([
                "dataSaved" => false,
                "message" => "Terjadi kesalahan saat menghapus data",
            ]);
        }
    }
    public function updateStatus(Request $request)
    {
        DB::table('transaksi')
            ->where('id', $request->id)
            ->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function deletePendingTransactions()
    {
        try {
            // Hitung jumlah transaksi pending yang akan dihapus
            $pendingCount = Transaksi::where('status', 'pending')->count();
            
            if ($pendingCount == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada transaksi pending yang ditemukan'
                ]);
            }

            // Hapus semua transaksi dengan status pending
            // Detail transaksi akan otomatis terhapus karena cascade delete
            Transaksi::where('status', 'pending')->delete();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$pendingCount} transaksi pending",
                'deleted_count' => $pendingCount
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus transaksi pending: ' . $th->getMessage()
            ]);
        }
    }
}
