@extends('layouts.main')

@section('content')
<h1 class="h3 mb-3">Invoice {{ $order->invoices }}</h1>
@can('isAdmin')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <p>Verifikasi bukti pembayaran <strong>{{ $order->invoices }} - {{ $order->nama_pemesan }}</strong></p>
        @if ($order->status == 'verifikasi')
        <div class="col-md-12">
          <a href="{{ asset('bukti_transfer/' . $order->bukti_transfer) }}" target="_blank">
            <span class="badge text-bg-info mb-3">Lihat bukti bayar</span>
          </a>
        </div>
        <form action="{{ route('pemesanan.verifikasi', $order->invoices) }}" method="POST" class="g-3">
          @csrf
          <input type="hidden" value="{{ $order->jadwals }}" name="jadwals_tolak">
          <div class="col-md-12">
            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan keterangan" required>
          </div>
          <div class="d-flex gap-3 mt-3">
            <button type="submit" name="action" value="terima" class="btn btn-primary w-100">
              Terima
            </button>
            <button type="submit" name="action" value="tolak" class="btn btn-danger w-100">
              Tolak
            </button>
          </div>
        </form>
        @elseif($order->status == 'ditolak')
        <span class="badge text-bg-danger">Pembayaran gagal</span>
        @elseif($order->status == 'pending')
        <span class="badge text-bg-info">Menunggu pembayaran</span>
        @elseif($order->status == 'sukses')
        <span class="badge text-bg-success">Pembayaran sukses</span>
        @endif
      </div>
    </div>
  </div>
</div>
@endcan

<div class="row">
  <div class="col-8">
    <div class="card">
      <div class="card-body">
        <div class="mb-4">
          Halo, <strong>{{ $order->nama_pemesan }}</strong>
          <br />
          Ini adalah tanda terima pembayaran sebesar <strong>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</strong> yang harus Anda lakukan.
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="text-muted">Invoice No.</div>
            <strong>{{ $order->invoices }}</strong>
          </div>
          <div class="col-md-6 text-md-end">
            <div class="text-muted">Tanggal Pemesanan Lapangan</div>
            <strong>{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->locale('id')->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}</strong>
          </div>
        </div>

        <hr class="my-2" />

        <div class="row">
          <div class="col-md-6">
            <div class="text-muted">Info Lapangan</div>
            <strong>{{ $order->lapangan->nama_lapangan }} - {{ $order->lapangan->jenis_lapangan }}</strong>
          </div>
          <div class="col-md-6 text-md-end">
            <div class="text-muted">Tanggal Pembayaran</div>
            <strong>
              @if ($order->status == "pending")
              <span class="text-danger">Belum melakukan pembayaran</span>
              @elseif($order->status == "ditolak")
              <span class="text-danger">Pembayaran ditolak dan gagal</span>
              @elseif($order->status == "verifikasi")
              <span class="text-info">Pembayaran menunggu verifikasi admin</span>
              @elseif($order->status == "sukses")
              {{ \Carbon\Carbon::parse($order->tanggal_selesai)->locale('id')->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
              @endif
            </strong>
          </div>
        </div>

        <hr class="my-2" />

        <table class="table table-sm">
          <thead>
            <tr>
              <th>Jam Main</th>
              <th>Sub Harga</th>
              <th class="text-end">Total</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jadwals as $jadwal)
              <tr>
                <td>{{ $jadwal->jam }}</td>
                <td>Rp. {{ number_format($order->lapangan->harga_lapangan, 0, ',', '.') }}</td>
                <td class="text-end"></td> 
              </tr>
            @endforeach
            <tr>
              <th>&nbsp;</th>
              <th>Total </th>
              <th class="text-end">Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</th>
            </tr>
          </tbody>
        </table>

        <div class="text-center">
          <p class="text-sm">
            <strong>Keterangan:</strong>
            @if ($order->status == 'pending')
            Silahkan melakukan pembayaran
            @elseif($order->status == 'ditolak')
            <span class="text-danger">Pembayaran ditolak : {{ $order->keterangan }}</span>
            @elseif($order->status == 'verifikasi')
            <span class="text-info">Pembayaran menunggu verifikasi admin</span>
            @elseif($order->status == 'sukses')
            <span>Pembayaran sukses</span>
            @endif
          </p>

          <a href="{{ route('pemesanan.index') }}" class="btn btn-primary">
            Kembali
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="col-4">
    <div class="card">
      <div class="card-body">
        <p>Pilih beberapa metode pembayaran dibawah agar pemesanan lapangan dapat diproses lebih lanjut.</p>

        <table class="table table-sm mt-2 mb-4">
          <tbody>
            <tr>
              <th>BCA</th>
              <td>55183819</td>
            </tr>
            <tr>
              <th>DANA</th>
              <td>087709237191</td>
            </tr>
            <tr>
              <th>SHOOPEPAY</th>
              <td>087709237191</td>
            </tr>
            <tr>
              <th>BRI</th>
              <td>87183799</td>
            </tr>
          </tbody>
        </table>
        @if ($order->status == 'pending')
        <form action="{{ route('pemesanan.uploadBukti', $order->invoices) }}" method="post" enctype="multipart/form-data" class="g-3">
          @csrf
          <div class="col-12">
            <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 mt-3">
            Kirim bukti pembayaran
          </button>
        </form>
        @elseif($order->status == 'ditolak')
        <span class="badge text-bg-danger">Pembayaran ditolak dan gagal</span>
        @elseif($order->status == 'verifikasi')
        <span class="badge text-bg-info">Pembayaran menunggu verifikasi admin</span>
        @elseif($order->status == 'sukses')
        <span class="badge text-bg-success">Pembayaran sukses</span>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection