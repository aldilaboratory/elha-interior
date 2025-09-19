<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BannerPromosiController;
use App\Http\Controllers\FooterPromosiController;
use App\Http\Controllers\ProdukBaruPromosiController;
use App\Http\Controllers\InfoPromosiController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\KabKotaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Landing\AuthController as LandingAuth;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\MetodeController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiDetailController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\LaporanStokController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Landing\CartController;
use App\Http\Controllers\Landing\CheckoutController;
use App\Http\Controllers\KomerceOngkirController;
use App\Models\InfoPromosi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Artisan;
// Route::get('/check-public-path', function () {
//     return public_path();
// });
// Route::get('/fix-cache', function () {
//     Artisan::call('config:clear');
//     Artisan::call('cache:clear');
//     Artisan::call('view:clear');
//     Artisan::call('route:clear');
//     Artisan::call('optimize:clear');
//     return 'Semua cache sudah dibersihkan.';
// });

// Route::get('/storage-link', function () {
//     \Illuminate\Support\Facades\Artisan::call('storage:link');
// });

Route::get("/", function () {
    return redirect()->to(route("shop"));
});
Route::get("/rajaongkir/provinsi", [
    KomerceOngkirController::class,
    "provinsi",
])->name("rajaongkir.provinsi");
Route::get("/rajaongkir/kota/{provinsi_id}", [
    KomerceOngkirController::class,
    "kota",
]);
Route::get("/rajaongkir/ongkir/{destination}/{courier}", [
    KomerceOngkirController::class,
    "ongkir",
]);

// Route::get("/", [LandingController::class, "index"])->name("landing");

Route::get('/pesanan/{id}/print', [\App\Http\Controllers\Landing\NotaPrintController::class, 'printNota'])->name('pesanan.print');
Route::put('/pesanan/{id}/terima', [\App\Http\Controllers\Landing\NotaPrintController::class, 'terimaPesanan'])->name('pesanan.terima');

Route::prefix("/landing")->group(function () {
    Route::get("/", [LandingController::class, "index"])->name("landing.index");
    Route::get("login", [LandingAuth::class, "index"])->name("landing.login");
    Route::get("registrasi", [LandingAuth::class, "registrasi"])->name(
        "landing.registrasi",
    );
    Route::post("registrasi", [LandingAuth::class, "setregistrasi"])->name(
        "landing.setregistrasi",
    );


    Route::get("/logout", [LandingAuth::class, "logout"])->name(
        "landing.logout",
    );

    // Profile pengguna routes
    Route::get("/profile", [
        \App\Http\Controllers\Landing\ProfileController::class,
        "index",
    ])->name("landing.profile")->middleware("auth");

    Route::put("/profile", [
        \App\Http\Controllers\Landing\ProfileController::class,
        "update",
    ])->name("landing.profile.update")->middleware("auth");

    Route::post("/profile/change-password", [
        \App\Http\Controllers\Landing\ProfileController::class,
        "changePassword",
    ])->name("landing.profile.change-password")->middleware("auth");

    Route::get("/profile-pengguna", [
        \App\Http\Controllers\Landing\ProfilLengkapPengguna::class,
        "index",
    ])
        ->name("landing.profile-pengguna")
        ->middleware("auth");

    Route::resource(
        "/alamat",
        \App\Http\Controllers\Landing\ProfilLengkapPengguna::class,
    );

    Route::post("/authenticate", [LandingAuth::class, "authenticate"])->name(
        "landing.authenticate",
    );

    Route::get("/pesanan_saya", [
        LandingController::class,
        "pesananSaya",
    ])->name("landing.pesanan");
    Route::put("/pesanan/{id}/terima", [
        LandingController::class,
        "terima",
    ])->name("pesanan.terima");
    Route::get("/shop", [LandingController::class, "shop"])->name("shop");
    Route::get("/shop/detail/{id}", [
        LandingController::class,
        "detailProduk",
    ])->name("shop.detail");

    Route::get("/all-products", [
        \App\Http\Controllers\Landing\AllProductController::class,
        "index",
    ])->name("landing.products");
    Route::get("/cart", [CartController::class, "index"])->name("landing.cart");
    Route::post("/cart/add", [CartController::class, "addToCart"])->name(
        "landing.cart.add",
    );
    Route::delete("/cart/{id}", [
        CartController::class,
        "deleteCartItem",
    ])->name("landing.cart.delete");
    Route::post("/cart/update-quantities", [
        CartController::class,
        "updateQuantities",
    ])->name("landing.cart.updateQuantities");

    Route::get("/checkout", [CheckoutController::class, "index"])->name(
        "landing.checkout",
    );
    Route::post("/checkout", [CheckoutController::class, "index"])->name(
        "landing.checkout.post",
    );
    Route::prefix("/checkout")->group(function () {
        Route::post("/process", [CheckoutController::class, "process"])->name(
            "landing.checkout.process",
        );
        Route::post("/payment/status", [
            CheckoutController::class,
            "changeStatus",
        ])->name("landing.payment.changestatus");
    });
    
    // Route untuk testing halaman payment
    Route::get("/payment", [CheckoutController::class, "payment"])->name(
        "landing.payment",
    );
});

Route::get("/login", [AuthController::class, "index"])->name("login");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");
Route::post("/authenticate", [AuthController::class, "authenticate"])->name(
    "authenticate",
);

Route::prefix("/admin")
    ->middleware(["auth", "admin.only"])
    ->group(function () {
        // Dashboard
        Route::get("dashboard", [DashboardController::class, "index"])->name(
            "dashboard",
        );

        // Profile
        Route::get("profile", [ProfileController::class, "index"])->name(
            "profile.index",
        );
        Route::get("profile/edit", [ProfileController::class, "edit"])->name(
            "profile.edit",
        );
        Route::post("profile", [ProfileController::class, "save"])->name(
            "profile.update",
        );

        // User
        Route::resource("user", UserController::class);
        Route::post("user/fetch", [UserController::class, "fetch"]);

        // Group
        Route::resource("group", GroupController::class);
        Route::post("group/fetch", [GroupController::class, "fetch"]);

        // Produk
        Route::resource("produk", ProdukController::class);
        Route::post("produk/fetch", [ProdukController::class, "fetch"]);

        // bannerPromosi
        Route::resource("bannerpromosi", BannerPromosiController::class);
        Route::post("bannerpromosi/fetch", [
            BannerPromosiController::class,
            "fetch",
        ])->name('bannerpromosi.fetch');

        // footerPromosi
        Route::resource("footerpromosi", FooterPromosiController::class);
        Route::post("footerpromosi/fetch", [
            FooterPromosiController::class,
            "fetch",
        ]);

        // produk baru Promosi
        Route::resource("produkbaru", ProdukBaruPromosiController::class);

        // produk info promosi
        Route::resource("infopromosi", InfoPromosiController::class);

        // Keranjang
        Route::resource("keranjang", KeranjangController::class);
        Route::post("keranjang/fetch", [KeranjangController::class, "fetch"]);

        // Kategori
        Route::resource("kategori", KategoriController::class);
        Route::post("kategori/fetch", [KategoriController::class, "fetch"]);

        // Status
        Route::resource("status", StatusController::class);
        Route::post("status/fetch", [StatusController::class, "fetch"]);

        // Provinsi
        Route::resource("provinsi", ProvinsiController::class);
        Route::post("provinsi/fetch", [ProvinsiController::class, "fetch"]);

        // KabKota
        Route::resource("kab_kota", KabKotaController::class);
        Route::post("kab_kota/fetch", [KabKotaController::class, "fetch"]);

        // Kecamatan
        Route::resource("kecamatan", KecamatanController::class);
        Route::post("kecamatan/fetch", [KecamatanController::class, "fetch"]);

        // Desa
        Route::resource("desa", DesaController::class);
        Route::post("desa/fetch", [DesaController::class, "fetch"]);

        // Ekspedisi
        Route::resource("ekspedisi", EkspedisiController::class);
        Route::post("ekspedisi/fetch", [EkspedisiController::class, "fetch"]);

        // Metode
        Route::resource("metode", MetodeController::class);
        Route::post("metode/fetch", [MetodeController::class, "fetch"]);

        // Transaksi
        Route::resource("transaksi", TransaksiController::class);
        Route::post("/update-status", [
            TransaksiController::class,
            "updateStatus",
        ]);
        Route::post("transaksi/fetch", [TransaksiController::class, "fetch"]);
        Route::delete("transaksi/delete-pending", [
            TransaksiController::class,
            "deletePendingTransactions",
        ])->name("transaksi.delete-pending");

        // TransaksiDetail
        Route::resource("transaksi_detail", TransaksiDetailController::class);
        Route::post("transaksi_detail/fetch", [
            TransaksiDetailController::class,
            "fetch",
        ]);

        // Laporan Penjualan
        Route::get("laporan-penjualan/generate-pdf", [
            LaporanPenjualanController::class,
            "generateReportPdf",
        ])->name("laporan-penjualan.generate-pdf");
        Route::post("laporan-penjualan/fetch", [
            LaporanPenjualanController::class,
            "fetch",
        ]);
        Route::get("laporan-penjualan/{id}/pdf", [
            LaporanPenjualanController::class,
            "downloadPdf",
        ])->name("laporan-penjualan.pdf");
        Route::resource("laporan-penjualan", LaporanPenjualanController::class);

        // Laporan Stok
        Route::get("laporan-stok/fetch", [
            LaporanStokController::class,
            "fetch",
        ]);
        Route::post("laporan-stok/update-stock", [
            LaporanStokController::class,
            "updateStock",
        ])->name("laporan-stok.update-stock");
        Route::resource("laporan-stok", LaporanStokController::class);
    });
