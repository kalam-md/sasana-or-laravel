<?php

namespace App\Http\Controllers\Jadwal;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        return view('jadwal.index', [
            'jadwals' => Jadwal::all(),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $jadwal = Jadwal::find($id);
        if ($jadwal) {
            $jadwal->aktif = $request->input('aktif');
            $jadwal->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
