@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Pemesanan Lapangan</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="row mb-3">
        <div class="col-4">
          <a href="{{ route('pemesanan.create') }}" type="button" class="btn btn-primary">
            <i data-feather="plus" class="text-white align-middle" style="vertical-align: middle;width:22px;height:22px;"></i> Tambah Pemesanan
          </a>
        </div>
      </div>
      <div class="row">
        <div class="col-12 d-flex">
          <div class="card flex-fill table-responsive">
            <table class="table table-hover table-bordered my-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Invoices</th>
                  <th>Pelanggan</th>
                  <th class="d-none d-xl-table-cell">Tanggal Transaksi</th>
                  <th class="d-none d-xl-table-cell">Nama Lapangan</th>
                  <th class="d-none d-xl-table-cell">Total</th>
                  <th class="d-none d-xl-table-cell">Status</th>
                  <th class="d-none d-md-table-cell text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>SCP{{ $order->invoices }}AD</td>
                    <td class="d-none d-xl-table-cell">{{ $order->user->fullname }}</td>
                    <td class="d-none d-xl-table-cell">
                      {{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->locale('id')->timezone('Asia/Jakarta')->isoFormat('dddd, D MMMM Y, [Jam] HH:mm [WIB]') }}
                    </td>
                    <td class="d-none d-xl-table-cell">{{ $order->lapangan->nama_lapangan }}</td>
                    <td class="d-none d-xl-table-cell">Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="d-none d-xl-table-cell">
                      <span class="badge text-bg-warning">{{ $order->status }}</span>
                    </td>
                    <td class="d-none d-md-table-cell text-center">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <a href="">
                                <i data-feather="eye" class="text-primary"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Data masih kosong</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection