<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotaPrintController extends Controller
{
    public function pesananSaya()
    {
        $orders = DB::table('transaksi')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->orderItems = DB::table('transaksi_detail')
                ->select(
                    'produk_id',
                    'gambar_produk as image',
                    'nama_produk',
                    'jumlah',
                    'harga'
                )
                ->where('transaksi_id', $order->id)
                ->get();
        }

        return view('landing.pesanan_saya', compact('orders'));
    }

    public function printNota($id)
    {
        $order = DB::table('transaksi')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            abort(404);
        }

        $orderItems = DB::table('transaksi_detail')
            ->where('transaksi_id', $id)
            ->get();

        return view('landing.nota_print', compact('order', 'orderItems'));
    }
}
