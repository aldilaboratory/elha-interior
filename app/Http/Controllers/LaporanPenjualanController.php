<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("administrator.laporan-penjualan.index");
    }

    /**
     * Fetch data for DataTables
     */
    public function fetch(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');

        $query = Transaksi::with(['user', 'transaksiDetail'])
            ->select('transaksi.*');

        // Apply date filter if provided
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Apply status filter if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        } else {
            // Default: hanya tampilkan transaksi yang sudah paid (bukan pending)
            $query->where('status', 'paid');
        }

        $transaksi = $query->orderBy('created_at', 'desc');

        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->addColumn('kode', function ($row) {
                return $row->order_id;
            })
            ->addColumn('tanggal', function ($row) {
                return Carbon::parse($row->created_at)->format('d/m/Y H:i');
            })
            ->addColumn('customer', function ($row) {
                return $row->user ? $row->user->name : '-';
            })
            ->addColumn('status', function ($row) {
                $badgeClass = $row->status == 'completed' ? 'success' : ($row->status == 'pending' ? 'warning' : 'info');
                return '<span class="badge badge-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('total', function ($row) {
                return 'Rp ' . number_format($row->total, 0, ',', '.');
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('laporan-penjualan.show', $row->id) . '" class="btn btn-sm btn-info">
                            <i class="fa fa-eye"></i> Detail
                        </a>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'transaksiDetail.produk'])
            ->findOrFail($id);

        return view('administrator.laporan-penjualan.show', compact('transaksi'));
    }

    /**
     * Generate PDF for transaction details
     */
    public function downloadPdf($id)
    {
        $transaksi = Transaksi::with(['user', 'transaksiDetail.produk'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('administrator.laporan-penjualan.pdf', compact('transaksi'));
        
        return $pdf->download('Detail_Transaksi_' . $transaksi->order_id . '.pdf');
    }

    /**
     * Generate PDF for sales report
     */
    public function generateReportPdf(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $status = $request->get('status');

        $query = Transaksi::with(['user', 'transaksiDetail'])
            ->select('transaksi.*');

        // Apply date filter if provided
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);
        }

        // Apply status filter if provided
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $transaksi = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate summary - only count paid transactions for revenue
        $totalTransaksi = $transaksi->count();
        $paidTransaksi = $transaksi->whereIn('status', ['paid', 'dibatalkan']);
        $totalPendapatan = $paidTransaksi->where('status', 'paid')->sum('total');
        $totalOngkir = $paidTransaksi->where('status', 'paid')->sum('ongkir');
        
        // Group by status
        $statusSummary = $transaksi->groupBy('status')->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total')
            ];
        });

        $data = [
            'transaksi' => $transaksi,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => $status,
            'totalTransaksi' => $totalTransaksi,
            'totalPendapatan' => $totalPendapatan,
            'totalOngkir' => $totalOngkir,
            'totalPaidTransaksi' => $paidTransaksi->where('status', 'paid')->count(),
            'statusSummary' => $statusSummary,
            'generatedAt' => Carbon::now()
        ];

        $pdf = Pdf::loadView('administrator.laporan-penjualan.report-pdf', $data);
        
        $filename = 'Laporan_Penjualan_' . 
                   ($startDate ? Carbon::parse($startDate)->format('d-m-Y') : 'All') . 
                   '_to_' . 
                   ($endDate ? Carbon::parse($endDate)->format('d-m-Y') : 'All') . 
                   '.pdf';
        
        return $pdf->download($filename);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}