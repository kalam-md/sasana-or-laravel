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
}
