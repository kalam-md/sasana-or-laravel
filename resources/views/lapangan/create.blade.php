@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Tambah Lapangan</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <form class="row g-3" method="post" action="{{ route('lapangan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-4">
              <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
              <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" required>
            </div>
            <div class="col-md-4">
              <label for="jenis_lapangan" class="form-label">Jenis Lapangan</label>
              <select class="form-select" id="jenis_lapangan" name="jenis_lapangan" required>
                <option selected disabled value="">--Pilih Jenis Lapangan--</option>
                <option value="Sintetis">Sintetis</option>
                <option value="Vinyil">Vinyil</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="harga_lapangan" class="form-label">Harga Lapangan</label>
              <div class="input-group">
                <span class="input-group-text" id="inputHargaLapangan">Rp.</span>
                <input type="number" class="form-control" id="harga_lapangan" name="harga_lapangan" aria-describedby="inputHargaLapangan" required>
              </div>
            </div>
            <div class="col-md-12">
              <label for="gambar" class="form-label">Gambar Lapangan</label>
              <input class="form-control" type="file" id="gambar" name="gambar_lapangan[]" multiple required>
            </div>
            <div class="col-md-12">
              <div class="preview-images-zone"></div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Simpan</button>
              <a href="{{ route('lapangan.index') }}" class="btn btn-light" type="submit">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection