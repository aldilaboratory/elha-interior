<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('landing.login');
        }

        $user = Auth::user();

        $cartItems = DB::table('keranjang')
            ->join('produk', 'keranjang.produk_id', '=', 'produk.id')
            ->where('keranjang.user_id', $user->id)
            ->select(
                'keranjang.*',
                'produk.nama as produk_nama',
                'produk.deskripsi as produk_deskripsi',
                'produk.harga as produk_harga',
                'produk.image as produk_image'
            )
            ->get();

        // 4. Kirim data ke view
        return view('landing.cart', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        // Validasi input
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        // Cek login
        if (!Auth::check()) {
            return redirect()->route('landing.login');
        }

        $userId = Auth::id();

        // Ambil data produk untuk cek stok
        $produk = Produk::find($request->produk_id);
        
        // Cek apakah stok tersedia
        if ($produk->stok <= 0) {
            return redirect()->back()->with('error', 'Produk ini sedang habis stok.');
        }

        // Cek apakah produk sudah ada di keranjang user
        $cartItem = Keranjang::where('user_id', $userId)
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($cartItem) {
            // Cek apakah total jumlah tidak melebihi stok
            $totalJumlah = $cartItem->jumlah + $request->jumlah;
            if ($totalJumlah > $produk->stok) {
                return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok tersedia. Stok tersisa: ' . $produk->stok);
            }
            
            // Update jumlah (tambah jumlah baru)
            $cartItem->update([
                'jumlah' => $totalJumlah
            ]);
        } else {
            // Cek apakah jumlah yang diminta tidak melebihi stok
            if ($request->jumlah > $produk->stok) {
                return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok tersedia. Stok tersisa: ' . $produk->stok);
            }
            
            // Insert baru
            Keranjang::create([
                'user_id' => $userId,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah
            ]);
        }

        return redirect()->route('landing.cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function deleteCartItem($id)
    {
        if (!Auth::check()) {
            return redirect()->route('landing.login');
        }

        $userId = Auth::id();

        // Cari item keranjang yang dimiliki user
        $cartItem = Keranjang::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return redirect()->route('landing.cart')->with('error', 'Item tidak ditemukan.');
        }

        try {
            $cartItem->delete();
            return redirect()->route('landing.cart')->with('success', 'Item berhasil dihapus dari keranjang.');
        } catch (\Exception $e) {
            return redirect()->route('landing.cart')->with('error', 'Terjadi kesalahan saat menghapus item.');
        }
    }

    public function updateQuantities(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'User tidak terautentikasi']);
        }

        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1|max:99'
        ]);

        $userId = Auth::id();
        $quantities = $request->quantities;
        $updatedCount = 0;

        try {
            foreach ($quantities as $itemId => $quantity) {
                $cartItem = Keranjang::where('id', $itemId)
                    ->where('user_id', $userId)
                    ->first();

                if ($cartItem) {
                    $cartItem->update(['jumlah' => $quantity]);
                    $updatedCount++;
                }
            }

            if ($updatedCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil memperbarui ' . $updatedCount . ' item'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada item yang berhasil diperbarui'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
