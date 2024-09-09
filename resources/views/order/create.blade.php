@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Tambah Pemesanan</strong></h1>

<div class="row">
  <div class="col-4 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Detail Pesanan</h5>
          <div id="lapangan-detail" class="col-md-12">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-8 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Buat Pesanan</h5>
          <form class="row g-3" method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
              <label for="lapangan_id" class="form-label">Lapangan</label>
              <select class="form-select" id="lapangan_id" name="lapangan_id" onchange="getLapanganDetail(this.value)" required>
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

<script>
  function getLapanganDetail(lapanganId) {
    if (lapanganId) {
      fetch(`/pemesanan/lapangan/detail/${lapanganId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            let gambarHtml = '';

            // Loop melalui gambar dan buat elemen <img> untuk setiap gambar
            data.data.gambar_lapangan.forEach(gambar => {
              gambarHtml += `
                <img 
                  src="/image/${gambar}" 
                  alt="${data.data.nama_lapangan}" 
                  class="img-fluid rounded mb-2" 
                  style="object-fit: cover; width: 130px; height: 80px" 
                />
              `;
            });

            document.getElementById('lapangan-detail').innerHTML = `
              <div class="d-flex gap-2 justify-content-between flex-wrap">
                ${gambarHtml}
              </div>
              <div class="d-flex flex-column mt-2 gap-2">
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Lapangan: </span><span>${data.data.nama_lapangan}</span>
                  </div>
                  <hr class="my-0" />
                </span>
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Jenis: </span><span>${data.data.jenis_lapangan}</span>
                  </div>
                  <hr class="my-0" />
                </span>
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Sub harga: </span><span>Rp. ${data.data.harga_lapangan}</span>
                  </div>
                  <hr class="my-0" />
                </span>
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Tanggal main: </span><span>22-08-2022</span>
                  </div>
                  <hr class="my-0" />
                </span>
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Jam main: </span><span>2 Jam</span>
                  </div>
                  <hr class="my-0" />
                </span>
                <span>
                  <div class="text-muted mb-2 d-flex justify-content-between">
                    <span>Total harga: </span><span>Rp. 180.000</span>
                  </div>
                  <hr class="my-0" />
                </span>
              </div>
            `;
          } else {
            document.getElementById('lapangan-detail').innerHTML = `<p>${data.message}</p>`;
          }
        })
        .catch(error => console.error('Error:', error));
    } else {
      document.getElementById('lapangan-detail').innerHTML = '';
    }
  }
</script>

@endsection