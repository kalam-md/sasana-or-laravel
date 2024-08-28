<?php

namespace App\Http\Controllers\Lapangan;

use App\Http\Controllers\Controller;
use App\Models\GambarLapangan;
use App\Models\Lapangan;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Image;
use Storage;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lapangan.index', [
            'lapangans' => Lapangan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lapangan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lapangan' => 'required|max:255',
            'jenis_lapangan' => 'required|max:255',
            'harga_lapangan' => 'required|max:255',
            'gambar_lapangan.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validatedData['slug'] = SlugService::createSlug(Lapangan::class, 'slug', $validatedData['nama_lapangan']);

        if ($request->hasFile('gambar_lapangan')) {
            foreach ($request->file('gambar_lapangan') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path() . '/image/', $namaGambar);
                $namaGambars[] = $namaGambar;
            }
        }

        $validatedData['gambar_lapangan'] = json_encode($namaGambars);
        Lapangan::create($validatedData);

        return redirect('/lapangan')->with('success', 'Lapangan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lapangan $lapangan)
    {
        return view('lapangan.show', [
            'lapangan' => $lapangan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lapangan $lapangan)
    {
        return view('lapangan.edit', [
            'lapangan' => $lapangan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lapangan $lapangan)
    {
        $validatedData = $request->validate([
            'nama_lapangan' => 'required|max:255',
            'jenis_lapangan' => 'required|max:255',
            'harga_lapangan' => 'required|max:255',
            'gambar_lapangan.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $validatedData['slug'] = SlugService::createSlug(Lapangan::class, 'slug', $validatedData['nama_lapangan']);

        if ($request->hasFile('gambar_lapangan')) {
            // Hapus gambar lama dari storage
            if (!empty($lapangan->gambar_lapangan)) {
                $gambarLama = json_decode($lapangan->gambar_lapangan, true); // Decode ke array
                if (is_array($gambarLama)) {
                    foreach ($gambarLama as $gambar) {
                        $path = public_path('image/' . $gambar);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }
            }

            // Upload gambar baru
            $namaGambars = []; // Array untuk menyimpan nama gambar baru
            foreach ($request->file('gambar_lapangan') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('image'), $namaGambar);
                $namaGambars[] = $namaGambar;
            }

            $validatedData['gambar_lapangan'] = json_encode($namaGambars);
        } else {
            // Jika tidak ada gambar baru yang diunggah, tetap gunakan gambar lama
            $validatedData['gambar_lapangan'] = $lapangan->gambar_lapangan;
        }

        Lapangan::where('id', $lapangan->id)->update($validatedData);

        return redirect('/lapangan')->with('success', 'Lapangan Berhasil Diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lapangan $lapangan)
    {
        // Hapus gambar dari storage
        if (!empty($lapangan->gambar_lapangan)) {
            $gambarLama = json_decode($lapangan->gambar_lapangan, true); // Decode ke array
            if (is_array($gambarLama)) {
                foreach ($gambarLama as $gambar) {
                    $path = public_path('image/' . $gambar);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

        Lapangan::destroy($lapangan->id);

        return redirect('/lapangan')->with('success', 'Lapangan Berhasil Dihapus');
    }
}
