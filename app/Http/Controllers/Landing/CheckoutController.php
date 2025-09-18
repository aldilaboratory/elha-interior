<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Services\ResiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use App\Models\ProfilLengkapPengguna as ModelProfilLengkapPengguna;
use Midtrans\Snap;

class CheckoutController extends Controller
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
        $total = $cartItems->sum(function ($item) {
            return $item->produk_harga * $item->jumlah;
        });

        $profiles = \App\Models\ProfilLengkapPengguna::where('user_id', Auth::id())->get();

        // 4. Kirim data ke view
        return view('landing.checkout', compact('cartItems', 'total', 'profiles'));
    }
    public function process(Request $request)
    {
        // 1. Validasi minimal
        $request->validate([
            'profile_id' => 'nullable|exists:profil_lengkap_penggunas,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'provinsi_id' => 'required',
            'provinsi_nama' => 'required',
            'kota_id' => 'required',
            'kota_nama' => 'required',
            'kurir' => 'required|string',
            'paket' => 'required|string',
            'ongkir' => 'required|numeric',
            'total' => 'required|numeric',
            'payment_method' => 'required|string',
        ]);

        // 2. Ambil cart user
        $cartItems = Keranjang::where('user_id', Auth::id())->join('produk', 'keranjang.produk_id', '=', 'produk.id')->select(
            'keranjang.*',
            'produk.nama as produk_nama',
            'produk.deskripsi as produk_deskripsi',
            'produk.harga as produk_harga',
            'produk.image as produk_image'
        )->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // 3. Ambil data penerima berdasarkan profil atau request
        $profile = null;
        if ($request->profile_id) {
            $profile = ProfilLengkapPengguna::where('id', $request->profile_id)
                ->where('user_id', Auth::id())
                ->first();
        }

        if ($profile) {
            $nama_penerima = $profile->name_penerima;
            $alamat = $profile->alamat;
            $no_hp = $profile->no_telp;
            $provinsi_id = $profile->provinsi_id;
            $provinsi_nama = $profile->provinsi_nama;
            $kota_id = $profile->kota_id;
            $kota_nama = $profile->kota_nama;
        } else {
            $nama_penerima = $request->nama;
            $alamat = $request->alamat;
            $no_hp = $request->no_hp;
            $provinsi_id = $request->provinsi_id;
            $provinsi_nama = $request->provinsi_nama;
            $kota_id = $request->kota_id;
            $kota_nama = $request->kota_nama;

            $existingProfile = ModelProfilLengkapPengguna::where('user_id', Auth::id())
                ->where('name_penerima', $nama_penerima)
                ->where('alamat', $alamat)
                ->where('no_telp', $no_hp)
                ->where('provinsi_id', $provinsi_id)
                ->where('kota_id', $kota_id)
                ->first();

            if (!$existingProfile) {
                ModelProfilLengkapPengguna::create([
                    'user_id' => Auth::id(),
                    'name_penerima' => $nama_penerima,
                    'alamat' => $alamat,
                    'no_telp' => $no_hp,
                    'provinsi_id' => $provinsi_id,
                    'provinsi_nama' => $provinsi_nama,
                    'kota_id' => $kota_id,
                    'kota_nama' => $kota_nama,
                ]);
            }
        }

        // 4. Buat transaksi
        $orderId = 'ORDER-' . time();
        $transaksi = Transaksi::create([
            'user_id'       => Auth::id(),
            'order_id'      => $orderId,
            'nama_penerima' => $nama_penerima,
            'alamat'        => $alamat,
            'no_hp'         => $no_hp,
            'provinsi_id'   => $provinsi_id,
            'provinsi_nama' => $provinsi_nama,
            'kota_id'       => $kota_id,
            'kota_nama'     => $kota_nama,
            'kurir'         => $request->kurir,
            'paket'         => $request->paket,
            'paket_harga'   => $request->ongkir,
            'paket_estimasi' => $request->paket_estimasi,
            'ongkir'        => $request->ongkir,
            'total'         => $request->total,
            'status'        => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // 5. Simpan detail barang
        foreach ($cartItems as $item) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $item->produk_id,
                'nama_produk' =>  $item->produk_nama,
                'gambar_produk' => $item->produk_image,
                'harga'        => $item->produk_harga,
                'jumlah'       => $item->jumlah,
                'subtotal'     => $item->produk_harga * $item->jumlah,
            ]);
        }

        // 6. Hapus cart
        Keranjang::where('user_id', Auth::id())->delete();

        // 7. Validasi total sebelum kirim ke Midtrans
        $grossAmount = (float) $request->total;
        
        // Pastikan gross_amount minimal 0.01 (sesuai requirement Midtrans)
        if ($grossAmount < 0.01) {
            return redirect()->back()->with('error', 'Total pembayaran tidak valid. Minimal Rp 0.01');
        }

        // 8. Kirim ke Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'      => $orderId,
                'gross_amount'  => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $nama_penerima,
                'phone'      => $no_hp,
                'address'    => $alamat,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Midtrans Error: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
                'user_id' => Auth::id()
            ]);
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }

        // 9. Kirim ke view pembayaran
        return view('landing.payment', [
            'snapToken' => $snapToken,
            'orderId'   => $orderId,
            'total'     => $grossAmount,
            'transaksi_id' => $transaksi->id
        ]);
    }

    public function changeStatus(Request $request)
    {
        // Validasi input minimal
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'payment_status' => 'required|string'
        ]);

        // Ambil transaksi
        $transaksi = Transaksi::findOrFail($request->transaksi_id);

        // Mapping status payment Midtrans ke status internal
        $statusMap = [
            'success'   => 'paid',
            'pending'   => 'pending',
            'failed'    => 'failed',
            'cancelled' => 'cancelled',
        ];

        $status = $statusMap[$request->payment_status] ?? 'pending';

        // Update transaksi
        $transaksi->update([
            'status'             => $status,
            'payment_type'       => $request->payment_type ?? null,
            'transaction_status' => $request->transaction_status ?? null,
            'transaction_id'     => $request->transaction_id ?? null,
            'status_code'        => $request->status_code ?? null,
            'gross_amount'       => $request->gross_amount ?? null,
            'signature_key'      => $request->signature_key ?? null,
        ]);

        // Generate resi dan kurangi stok jika pembayaran berhasil
        if ($status === 'paid') {
            $resi = ResiService::generateResiByCourier($transaksi->kurir);
            $transaksi->update(['resi' => $resi]);
            
            // Kurangi stok produk berdasarkan transaksi detail
            $transaksiDetails = TransaksiDetail::where('transaksi_id', $transaksi->id)->get();
            
            foreach ($transaksiDetails as $detail) {
                $produk = Produk::find($detail->produk_id);
                if ($produk) {
                    // Kurangi stok produk
                    $produk->stok = $produk->stok - $detail->jumlah;
                    $produk->save();
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status transaksi berhasil diperbarui',
            'data'    => $transaksi
        ]);
    }
}
