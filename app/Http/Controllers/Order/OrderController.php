<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            'nama_pemesan' => 'required',
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
            'invoices' => 'SC' . Str::random(10) . 'AD',
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => $request->tanggal_pemesanan,
            'total_harga' => $totalHarga,
            'status' => 'pending',
            'user_id' => auth()->id(),
            'lapangan_id' => $request->lapangan_id,
            'jadwals' => json_encode($request->jadwals),
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    public function pemesananDetail($invoices)
    {
        // Cari detail pemesanan berdasarkan invoices
        $order = Order::where('invoices', $invoices)
            ->where('user_id', Auth::id()) // Pastikan hanya order milik user yang login
            ->firstOrFail();

        // Cek jika pesanan ditemukan
        if (!$order) {
            // Redirect atau tampilkan pesan error jika pesanan tidak ditemukan
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan.');
        }

        // Decode JSON jadwals dari order
        if ($order->status === 'ditolak') {
            // Decode JSON jadwals_tolak jika status ditolak
            $jadwalIdsString = json_decode($order->jadwals_tolak, true);
        } else {
            // Decode JSON jadwals jika status bukan ditolak
            $jadwalIdsString = json_decode($order->jadwals, true);
        }

        // Pecah string menjadi array berdasarkan koma
        $jadwalIds = explode(',', $jadwalIdsString[0]);

        // Ambil e-book berdasarkan ID yang ada di dalam order
        $jadwals = Jadwal::whereIn('id', $jadwalIds)->get();

        // Tampilkan view detail pemesanan
        return view('order.detail', [
            'order' => $order,
            'jadwals' => $jadwals
        ]);
    }

    public function pemesananCetak($invoices)
    {
        // Cari detail pemesanan berdasarkan invoices
        $order = Order::where('invoices', $invoices)
            ->where('user_id', Auth::id()) // Pastikan hanya order milik user yang login
            ->firstOrFail();

        // Cek jika pesanan ditemukan
        if (!$order) {
            // Redirect atau tampilkan pesan error jika pesanan tidak ditemukan
            return redirect()->back()->with('error', 'Pemesanan tidak ditemukan.');
        }

        // Decode JSON jadwals dari order
        if ($order->status === 'ditolak') {
            // Decode JSON jadwals_tolak jika status ditolak
            $jadwalIdsString = json_decode($order->jadwals_tolak, true);
        } else {
            // Decode JSON jadwals jika status bukan ditolak
            $jadwalIdsString = json_decode($order->jadwals, true);
        }

        // Pecah string menjadi array berdasarkan koma
        $jadwalIds = explode(',', $jadwalIdsString[0]);

        // Ambil e-book berdasarkan ID yang ada di dalam order
        $jadwals = Jadwal::whereIn('id', $jadwalIds)->get();

        // Tampilkan view detail pemesanan
        return view('order.cetak', [
            'order' => $order,
            'jadwals' => $jadwals
        ]);
    }

    public function uploadBuktiBayar(Request $request, $invoices)
    {
        // Validasi input file
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi tipe gambar
        ]);

        // Cari order berdasarkan invoices
        $order = Order::where('invoices', $invoices)
            ->where('user_id', Auth::id()) // Hanya milik user yang login
            ->firstOrFail();

        // Upload file bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            // Ambil order berdasarkan invoices
            $order = Order::where('invoices', $invoices)->firstOrFail();

            // Hapus bukti transfer lama jika ada
            if ($order->bukti_transfer) {
                $oldFilePath = public_path('bukti_transfer/' . $order->bukti_transfer);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Simpan bukti transfer baru ke dalam folder public
            $fileName = time() . '_' . $request->file('bukti_transfer')->getClientOriginalName();
            $request->file('bukti_transfer')->move(public_path('bukti_transfer'), $fileName);

            // Update order dengan bukti transfer
            $order->update([
                'bukti_transfer' => $fileName,
                'tanggal_selesai' => Carbon::now(),
                'status' => 'verifikasi',
            ]);
        }


        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload dan menunggu verifikasi.');
    }

    public function verifikasiPembayaran(Request $request, $invoices)
    {
        // Cari order berdasarkan invoices
        $order = Order::where('invoices', $invoices)->firstOrFail();

        // Tentukan tindakan berdasarkan tombol yang ditekan
        if ($request->input('action') === 'terima') {
            // Update status order menjadi sukses
            $order->update([
                'status' => 'sukses',
                'keterangan' => $request->input('keterangan'),
            ]);
            return redirect()->back()->with('success', 'Pembayaran telah diterima dan status pemesanan menjadi sukses.');
        } elseif ($request->input('action') === 'tolak') {
            // Update status order menjadi ditolak
            $order->update([
                'status' => 'ditolak',
                'jadwals' => null,
                'jadwals_tolak' => $request->input('jadwals_tolak'),
                'keterangan' => $request->input('keterangan'),
            ]);
            return redirect()->back()->with('error', 'Pembayaran telah ditolak dan status pemesanan menjadi ditolak.');
        }

        // Jika tidak ada tindakan yang valid
        return redirect()->back()->with('error', 'Tindakan tidak valid.');
    }
}
