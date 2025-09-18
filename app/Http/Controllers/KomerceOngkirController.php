<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KomerceOngkirController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env("RAJAONGKIR_API_KEY");
        $this->baseUrl = env("RAJAONGKIR_BASE_URL");
    }

    public function provinsi()
    {
        // Cek apakah tabel provinsi kosong
        $provinsi = DB::table("provinsi")->get();

        if ($provinsi->isEmpty()) {
            // Ambil dari API
            $response = Http::withHeaders([
                "Key" => $this->apiKey,
            ])->get("{$this->baseUrl}/destination/province");

            $data = $response->json();

            if (isset($data["data"]) && is_array($data["data"])) {
                // Simpan ke DB

                foreach ($data["data"] as $prov) {
                    DB::table("provinsi")->insert([
                        "id" => $prov["id"],
                        "nama" => $prov["name"],
                    ]);
                }
            }

            // Ambil data baru dari DB
            $provinsi = DB::table("provinsi")->get();
        }

        // Return JSON dari database
        return response()->json($provinsi);
    }

    public function kota($provinceId)
    {
        $response = Http::withHeaders([
            "Key" => $this->apiKey,
        ])->get("{$this->baseUrl}/destination/city/$provinceId");

        return response()->json($response->json());
    }

    public function ongkir($destination, $courier)
    {
        $response = Http::asForm()
            ->withHeaders([
                "key" => $this->apiKey,
            ])
            ->post("{$this->baseUrl}/calculate/district/domestic-cost", [
                "origin" => env("RAJAONGKIR_ORIGIN"),
                "destination" => $destination,
                "weight" => 1000,
                "courier" => $courier,
                "price" => "lowest",
            ]);

        return response()->json($response->json());
    }
}
