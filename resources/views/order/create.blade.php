@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Tambah Pemesanan</strong></h1>

<div class="row">
  <div class="col-4 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Detail Pemesanan</h5>
          <div class="col-md-12">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-8 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <form class="row g-3" method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
              <label for="lapangan_id" class="form-label">Lapangan</label>
              <select class="form-select" id="lapangan_id" name="lapangan_id" required>
                  <option selected disabled value="">--Pilih Lapangan--</option>
                  @foreach ($lapangans as $lapangan)
                      <option value="{{ $lapangan->id }}">{{ $lapangan->nama_lapangan }}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan/Booking</label>
              <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-12">
              <label for="jenis_lapangan" class="form-label">Jam Pemesanan/Booking</label>
              <div class="d-flex flex-wrap justify-content-start gap-2">
                @foreach ($jadwals as $jadwal)
                  @if ($jadwal->aktif == 1)
                  <div 
                  class="d-flex flex-column justify-content-center align-items-center text-center p-2 gap-1 rounded shadow-lg border"
                  style="width: 115px; height: auto;">
                    <i class="align-middle" data-feather="clock" style="width:40px;height:40px;"></i>
                    <span>{{ $jadwal->jam }}</span>
                    <small><span class="badge text-bg-primary">Tersedia</span></small>
                  </div>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Simpan</button>
              <a href="{{ route('pemesanan.index') }}" class="btn btn-light" type="submit">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection