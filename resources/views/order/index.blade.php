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
                  <th>Invoice</th>
                  <th>Pelanggan</th>
                  <th class="d-none d-xl-table-cell">Tanggal Transaksi</th>
                  <th class="d-none d-xl-table-cell">Nama Lapangan</th>
                  <th class="d-none d-xl-table-cell">Total</th>
                  <th class="d-none d-xl-table-cell">Status</th>
                  <th class="d-none d-md-table-cell text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                {{-- @forelse ($lapangans as $lapangan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $lapangan->nama_lapangan }}</td>
                    <td class="d-none d-xl-table-cell">{{ $lapangan->jenis_lapangan }}</td>
                    <td class="d-none d-xl-table-cell">Rp. {{ number_format($lapangan->harga_lapangan, 0, ',', '.') }}/Jam</td>
                    <td class="d-none d-md-table-cell text-center">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <a href="{{ route('lapangan.show', $lapangan->slug) }}">
                                <i data-feather="eye" class="text-primary"></i>
                            </a>
                            <a href="{{ route('lapangan.edit', $lapangan->slug) }}">
                                <i data-feather="edit" class="text-success"></i>
                            </a>
                            <form action="{{ route('lapangan.destroy', $lapangan->slug) }}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline" onclick="return confirm('Apakah yakin ingin menghapus data?')">
                                    <i data-feather="trash-2" class="text-danger" style="width:20px;height:20px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data masih kosong</td>
                </tr>
                @endforelse --}}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection