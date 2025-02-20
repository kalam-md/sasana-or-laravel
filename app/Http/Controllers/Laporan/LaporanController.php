<?php

namespace App\Http\Controllers\Laporan;

use App\Exports\OrdersExport as ExportsOrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrdersExport;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index() 
    {
        return view('laporan.index');
    }

    public function exportPDF(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $orders = Order::whereBetween('tanggal_pemesanan', [$request->tanggal_awal, $request->tanggal_akhir])->get();

        $pdf = FacadePdf::loadView('laporan.pdf', compact('orders'));

        return $pdf->download('laporan_orders.pdf');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        return Excel::download(new ExportsOrdersExport($request->tanggal_awal, $request->tanggal_akhir), 'laporan_orders.xlsx');
    }
}
