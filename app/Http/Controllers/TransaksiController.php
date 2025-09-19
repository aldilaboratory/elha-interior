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
        $transaksiDetail = DB::table('transaksi_detail')
            ->join('transaksi', 'transaksi.id', '=', 'transaksi_detail.transaksi_id')
            ->join('user', 'user.id', '=', 'transaksi.user_id')
            ->leftJoin('produk', 'produk.id', '=', 'transaksi_detail.produk_id')
            ->select(
                'transaksi_detail.id as detail_id',
                'transaksi.id as transaksi_id',
                'transaksi.nama_penerima as nama_penerima',
                'transaksi.status as status',
                'transaksi.total as total',
                'transaksi.paket_estimasi as estimasi',
                DB::raw('COALESCE(transaksi.resi, "-") as resi'),
                'user.name as nama_user',
                DB::raw('COALESCE(produk.nama, transaksi_detail.nama_produk) as nama_produk'),
                'transaksi_detail.gambar_produk as gambar_produk',
                'transaksi_detail.jumlah as qty',
                'transaksi_detail.harga as harga',
                'transaksi_detail.subtotal as subtotal',
                'transaksi.created_at'
            )
            ->orderBy('transaksi.id', 'desc')
            ->orderBy('transaksi_detail.id', 'asc');

        return DataTables::of($transaksiDetail)
            ->addIndexColumn()
            ->addColumn('gambar_produk', function($row) {
                if ($row->gambar_produk) {
                    return '<img src="' . asset('upload/produk/' . $row->gambar_produk) . '" alt="' . $row->nama_produk . '" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                }
                return '<div style="width: 50px; height: 50px; background-color: #f8f9fa; border-radius: 5px; display: flex; align-items: center; justify-content: center; color: #6c757d;">No Image</div>';
            })
            ->addColumn('aksi', function($row) {
                return '
                    <div class="btn-group" role="group">
                        <a href="' . route('transaksi.edit', $row->transaksi_id) . '" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteData(' . $row->transaksi_id . ')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['gambar_produk', 'aksi'])
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
