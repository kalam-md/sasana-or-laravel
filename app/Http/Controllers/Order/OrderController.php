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
            'orders' => Order::all()
        ]);
    }

    public function create()
    {
        // Ambil semua jadwals dan lapangan
        $jadwals = Jadwal::all();
        $lapangans = Lapangan::all();

        return view('order.create', [
            'jadwals' => $jadwals,
            'lapangans' => $lapangans,
        ]);
    }

    public function getBookedJadwals(Request $request)
    {
        $lapanganId = $request->input('lapangan_id');
        $tanggal = $request->input('tanggal_pemesanan');

        $bookedJadwals = Order::where('lapangan_id', $lapanganId)
            ->where('tanggal_pemesanan', $tanggal)
            ->pluck('jadwals')
            ->flatten()
            ->map(function ($item) {
                return json_decode($item);
            })
            ->flatten()
            ->unique()
            ->values();

        return response()->json($bookedJadwals);
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
        // Validasi input
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'tanggal_pemesanan' => 'required|date',
            'jadwals' => 'required|array',
            'jadwals.*' => 'exists:jadwals,id',
        ]);

        // Ambil data lapangan
        $lapangan = Lapangan::find($request->lapangan_id);
        $hargaLapangan = $lapangan->harga_lapangan;

        // Hitung total harga berdasarkan jumlah jadwal yang dipilih
        $jumlahJadwals = explode(',', $request->jadwals[0]);
        $jumlahJadwalsArray = count($jumlahJadwals);
        $totalHarga = $jumlahJadwalsArray * $hargaLapangan;

        // Buat pesanan
        Order::create([
            'invoices' => Str::random(10),
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'total_harga' => $totalHarga,
            'status' => 'pending',
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'jadwals' => json_encode($request->jadwals),
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
