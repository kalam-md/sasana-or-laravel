@extends('layouts.main')

@section('content')
<h1 class="h3 mb-3">Invoice {{ $order->invoices }}</h1>

<div class="row">
  <div class="col-12">
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
              <span class="text-danger">Pembayaran ditolak</span>
              @elseif($order->status == "kadaluarsa")
              <span class="text-danger">Pembayaran kadaluarsa</span>
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
            @elseif($order->status == 'kadaluarsa')
            <span class="text-danger">Pembayaran anda kadaluarsa karena sudah lewat dari 24 jam</span>
            @elseif($order->status == 'verifikasi')
            <span class="text-info">Pembayaran menunggu verifikasi admin</span>
            @elseif($order->status == 'sukses')
            <span>Pembayaran sukses</span>
            @endif
          </p>

          <a href="{{ route('pemesanan.index') }}" class="btn btn-primary">
            Kembali
          </a>
          @if ($order->status == 'sukses')
          <button class="btn btn-danger" onclick="window.print()">
            Cetak PDF
          </button>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection