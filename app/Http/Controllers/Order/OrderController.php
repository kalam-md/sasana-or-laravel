<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', [
            'lapangans' => Lapangan::all()
        ]);
    }

    public function create()
    {
        return view('order.create', [
            'jadwals' => Jadwal::all(),
            'lapangans' => Lapangan::all()
        ]);
    }

    public function getDetail($id)
    {
        $lapangan = Lapangan::find($id);

        if ($lapangan) {
            // Decode gambar dari JSON ke array
            $gambar_lapangan = json_decode($lapangan->gambar_lapangan);

            return response()->json([
                'success' => true,
                'data' => [
                    'nama_lapangan' => $lapangan->nama_lapangan,
                    'jenis_lapangan' => $lapangan->jenis_lapangan,
                    'harga_lapangan' => number_format($lapangan->harga_lapangan, 0, ',', '.'),
                    'gambar_lapangan' => $gambar_lapangan,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Lapangan tidak ditemukan.'
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_pemesanan' => 'required|date',
            'jadwals' => 'required|array',
            'jadwals.*' => 'exists:jadwals,id',
        ]);
        // dd($request->all());
        // Fetch lapangan and check harga_lapangan
        $lapangan = Lapangan::find($request->lapangan_id);

        // Calculate the total price
        $totalHarga = count($request->jadwals) * $lapangan->harga_lapangan;

        // Create the order
        Order::create([
            'invoices' => Str::random(10), // Generate a unique invoice number
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'total_harga' => $totalHarga,
            'status' => 'pending', // Default status
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'jadwals' => json_encode($request->jadwals), // Store selected schedules as JSON
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
    }

    // public function store(Request $request)
    // {
    //     // Debugging route hit
    //     Log::info('Store method hit');

    //     // Debugging request data
    //     Log::info($request->all());

    //     // Validate the request
    //     $request->validate([
    //         'lapangan_id' => 'required|exists:lapangans,id',
    //         'tanggal_pemesanan' => 'required|date',
    //         'jadwals' => 'required|array',
    //         'jadwals.*' => 'exists:jadwals,id',
    //     ]);

    //     // Calculate the total price
    //     $lapangan = Lapangan::find($request->lapangan_id);
    //     $totalHarga = count($request->jadwals) * $lapangan->harga_lapangan;
    //     Log::info('Total Harga: ' . $totalHarga);

    //     // Create the order
    //     Order::create([
    //         'invoices' => Str::random(10), // Generate a unique invoice number
    //         'tanggal_pemesanan' => $request->tanggal_pemesanan,
    //         'total_harga' => $totalHarga,
    //         'status' => 'pending', // Default status
    //         'user_id' => auth()->id(),
    //         'lapangan_id' => $request->lapangan_id,
    //         'jadwals' => json_encode($request->jadwals), // Store selected schedules as JSON
    //     ]);

    //     return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat!');
    // }
}
