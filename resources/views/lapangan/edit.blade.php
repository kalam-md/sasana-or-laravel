@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Edit Lapangan</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <form class="row g-3" method="post" action="{{ route('lapangan.update', $lapangan->slug) }}" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="col-md-4">
              <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
              <input type="text" class="form-control" id="nama_lapangan" name="nama_lapangan" value="{{ $lapangan->nama_lapangan }}">
            </div>
            <div class="col-md-4">
              <label for="jenis_lapangan" class="form-label">Jenis Lapangan</label>
              <select class="form-select" id="jenis_lapangan" name="jenis_lapangan">
                <option disabled value="">--Pilih Jenis Lapangan--</option>
                <option value="Sintetis" {{ $lapangan->jenis_lapangan == 'Sintetis' ? 'selected' : '' }}>Sintetis</option>
                <option value="Vinyil" {{ $lapangan->jenis_lapangan == 'Vinyil' ? 'selected' : '' }}>Vinyil</option>
              </select>
            </div>
            <div class="col-md-4">
              <label for="harga_lapangan" class="form-label">Harga Lapangan</label>
              <div class="input-group">
                <span class="input-group-text" id="inputHargaLapangan">Rp.</span>
                <input type="number" class="form-control" id="harga_lapangan" name="harga_lapangan" aria-describedby="inputHargaLapangan" value="{{ $lapangan->harga_lapangan }}">
              </div>
            </div>
            <div class="col-md-12">
              <label for="gambar" class="form-label">Gambar Lapangan</label>
              <input class="form-control" type="file" id="gambar" name="gambar_lapangan[]" multiple>
            </div>
            <div class="col-md-12">
              <div class="preview-images-zone">
                @foreach (json_decode($lapangan->gambar_lapangan) as $gambar)
                  <div class="preview-image">
                    <img src="{{ asset('/image/'.$gambar) }}" alt="" style="height: 150px; width: 250px">
                  </div>
                @endforeach
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Edit</button>
              <a href="{{ route('lapangan.index') }}" class="btn btn-light" type="submit">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection