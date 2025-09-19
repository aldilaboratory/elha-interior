<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BannerPromosi;
use App\Models\InfoPromosi;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\ProdukBaruPromosi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function shop(Request $request)
    {
        $query = Produk::join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.nama as kategori_nama');

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('produk.kategori_id', $request->category);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('produk.nama', 'like', '%' . $request->search . '%');
        }

        $data = $query->take(8)->get();

        // Ambil kategori untuk menu/filter
        $kategoris = Kategori::all();
        $bannerPromosi = BannerPromosi::all();
        $produkBaruPromosi = ProdukBaruPromosi::first();
        $infoPromosi = InfoPromosi::first();

        return view('landing.shop', [
            'data' => $data,
            'kategoris' => $kategoris,
            'bannerPromosi' => $bannerPromosi,
            'produkBaruPromosi' => $produkBaruPromosi,
            'infoPromosi' => $infoPromosi

        ]);
    }
    public function detailProduk($id)
    {
        $data = Produk::join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.*', 'kategori.nama as kategori_nama')
            ->where('produk.id', $id)
            ->first();
        return view('landing.detail', ['data' => $data]);
    }

    public function pesananSaya()
    {
        $orders = DB::table('transaksi')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Loop setiap transaksi dan ambil detailnya
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

        // Ambil kategori dari produk yang ada di cart user saat ini
        $cartCategories = DB::table('keranjang')
            ->join('produk', 'keranjang.produk_id', '=', 'produk.id')
            ->where('keranjang.user_id', Auth::id())
            ->pluck('produk.kategori_id')
            ->unique()
            ->toArray();

        // Jika tidak ada cart, ambil kategori dari pesanan terakhir
        if (empty($cartCategories) && !$orders->isEmpty()) {
            $lastOrderProductIds = $orders->first()->orderItems->pluck('produk_id')->toArray();
            $cartCategories = DB::table('produk')
                ->whereIn('id', $lastOrderProductIds)
                ->pluck('kategori_id')
                ->unique()
                ->toArray();
        }

        // Ambil produk rekomendasi berdasarkan kategori yang sama
        $recommendedProducts = collect();
        if (!empty($cartCategories)) {
            $recommendedProducts = DB::table('produk')
                ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
                ->select('produk.*', 'kategori.nama as kategori_nama')
                ->whereIn('produk.kategori_id', $cartCategories)
                ->where('produk.stok', '>', 0)
                ->inRandomOrder()
                ->limit(8)
                ->get();
        }

        return view('landing.pesanan_saya', compact('orders', 'recommendedProducts'));
    }
    public function terima($id)
    {
        DB::table('transaksi')
            ->where('id', $id)
            ->update(['status' => 'selesai']);

        return redirect()->back()->with('success', 'Pesanan diterima.');
    }
}
