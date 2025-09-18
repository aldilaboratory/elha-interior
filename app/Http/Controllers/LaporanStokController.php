<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LaporanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view("administrator.laporan-stok.index", compact('kategori'));
    }

    /**
     * Fetch data for DataTables
     */
    public function fetch(Request $request)
    {
        $kategoriId = $request->get('kategori_id');
        $stokFilter = $request->get('stok_filter'); // 'low', 'empty', 'all'

        $query = Produk::with('kategori')
            ->select('produk.*');

        // Apply category filter if provided
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        // Apply stock filter
        if ($stokFilter === 'low') {
            $query->where('stok', '<=', 10)->where('stok', '>', 0);
        } elseif ($stokFilter === 'empty') {
            $query->where('stok', '<=', 0);
        }

        $produk = $query->get();

        return DataTables::of($produk)
            ->addIndexColumn()
            ->addColumn('nama', function ($row) {
                return $row->nama_produk;
            })
            ->addColumn('kategori', function ($row) {
                return $row->kategori ? $row->kategori->nama : '-';
            })
            ->addColumn('gambar', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset('upload/produk/' . $row->image) . '" alt="' . $row->nama . '" style="width:80px; height:auto;">';
                }
                return '<img src="' . asset('assets/images/placeholder.jpg') . '" alt="No Image" style="width:80px; height:auto;">';
            })
            ->addColumn('harga', function ($row) {
                return 'Rp ' . number_format($row->harga, 0, ',', '.');
            })
            ->addColumn('status_stok', function ($row) {
                if ($row->stok <= 0) {
                    return '<span class="badge badge-danger">Habis</span>';
                } elseif ($row->stok <= 10) {
                    return '<span class="badge badge-warning">Stok Rendah</span>';
                } else {
                    return '<span class="badge badge-success">Tersedia</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('laporan-stok.show', $row->id) . '" class="btn btn-sm btn-info me-1">
                            <i class="fa fa-eye"></i> Detail
                        </a>
                        <button type="button" class="btn btn-sm btn-warning" onclick="editStock(' . $row->id . ', \'' . addslashes($row->nama_produk) . '\', ' . $row->stok . ')">
                            <i class="fa fa-edit"></i> Edit Stok
                        </button>';
            })
            ->rawColumns(['gambar', 'status_stok', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view("administrator.laporan-stok.show", compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Update stock for a specific product
     */
    public function updateStock(Request $request)
    {
        try {
            $request->validate([
                'produk_id' => 'required|exists:produk,id',
                'stok' => 'required|integer|min:0|max:999999'
            ], [
                'produk_id.required' => 'ID produk harus diisi',
                'produk_id.exists' => 'Produk tidak ditemukan',
                'stok.required' => 'Stok harus diisi',
                'stok.integer' => 'Stok harus berupa angka',
                'stok.min' => 'Stok tidak boleh kurang dari 0',
                'stok.max' => 'Stok tidak boleh lebih dari 999,999'
            ]);

            $produk = Produk::findOrFail($request->produk_id);
            $stokLama = $produk->stok;
            
            // Check if stock value actually changed
            if ($stokLama == $request->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak berubah dari nilai sebelumnya'
                ], 400);
            }
            
            $produk->stok = $request->stok;
            $produk->save();

            $message = $request->stok > $stokLama 
                ? "Stok berhasil ditambah dari {$stokLama} menjadi {$request->stok}"
                : "Stok berhasil dikurangi dari {$stokLama} menjadi {$request->stok}";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'produk_id' => $produk->id,
                    'nama_produk' => $produk->nama,
                    'stok_lama' => $stokLama,
                    'stok_baru' => $produk->stok
                ]
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui stok: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}