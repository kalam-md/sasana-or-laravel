<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Order;
use Illuminate\Http\Request;

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

    public function getJamPemesanan(Request $request)
    {
        $lapanganId = $request->lapangan_id;
        $tanggalPemesanan = $request->tanggal_pemesanan;

        // Ambil semua jadwal yang sudah dipesan untuk lapangan dan tanggal yang dipilih
        $bookedJadwals = Order::where('lapangan_id', $lapanganId)
            ->where('tanggal_pemesanan', $tanggalPemesanan)
            ->pluck('jadwal_id');

        // Ambil semua jadwal yang aktif untuk lapangan yang dipilih, kecuali jadwal yang sudah dipesan
        $jadwals = Jadwal::where('lapangan_id', $lapanganId)
            ->whereNotIn('id', $bookedJadwals)
            ->where('aktif', 1)
            ->get();

        return response()->json([
            'jadwals' => $jadwals
        ]);
    }
}
