<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class AllProductController extends Controller
{
    public function index(Request $request)
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

        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('produk.harga', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('produk.harga', '<=', $request->max_price);
        }

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('produk.harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('produk.harga', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('produk.nama', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('produk.nama', 'desc');
                break;
            case 'newest':
                $query->orderBy('produk.created_at', 'desc');
                break;
            default:
                $query->orderBy('produk.id', 'desc');
                break;
        }

        // Pagination
        $data = $query->paginate(32);

        // Get categories with product count
        $categories = Kategori::withCount(['produk as products_count' => function ($query) use ($request) {
            // Apply same filters for counting
            if ($request->filled('search')) {
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
            if ($request->filled('min_price')) {
                $query->where('harga', '>=', $request->min_price);
            }
            if ($request->filled('max_price')) {
                $query->where('harga', '<=', $request->max_price);
            }
        }])->get();

        // Get total products count
        $totalProductsQuery = Produk::query();

        // Apply same filters for total count
        if ($request->filled('search')) {
            $totalProductsQuery->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('min_price')) {
            $totalProductsQuery->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $totalProductsQuery->where('harga', '<=', $request->max_price);
        }

        $totalProducts = $totalProductsQuery->count();

        $maxPrice = Produk::max('harga') ?? 10000000;

        return view('landing.all-products', [
            'data' => $data,
            'categories' => $categories,
            'totalProducts' => $totalProducts,
            'maxPrice' => $maxPrice,
        ]);
    }
}
