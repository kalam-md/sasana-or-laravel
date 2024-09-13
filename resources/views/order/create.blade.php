@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Tambah Pemesanan</strong></h1>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
          <form class="row g-3" method="post" action="{{ route('pemesanan.store') }}" enctype="multipart/form-data">
            @csrf
            <textarea name="jadwals[]" id="jadwals" style="display:none;"></textarea> <!-- Hidden input untuk jadwals -->
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
              <input type="date" class="form-control" id="tanggal_pemesanan" name="tanggal_pemesanan" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled required>
            </div>
            <div class="col-md-12" id="jam-pemesanan-section" style="display: none;">
              <label for="jenis_lapangan" class="form-label">Jam Pemesanan/Booking</label>
              <div id="jadwal-container" class="d-flex flex-wrap justify-content-start gap-2">
                @foreach ($jadwals as $jadwal)
                  @if ($jadwal->aktif == 1)
                  <div 
                    class="jadwal-item d-flex flex-column justify-content-center align-items-center text-center p-2 gap-1 rounded shadow-lg border"
                    data-jadwal-id="{{ $jadwal->id }}"
                    data-jam="{{ $jadwal->jam }}"
                    onclick="toggleSelectJadwal(this)"
                    style="width: 115px; height: auto; cursor: pointer;">
                    <i class="align-middle" data-feather="clock" style="width:40px;height:40px;"></i>
                    <span>{{ $jadwal->jam }}</span>
                    <small><span class="badge text-bg-primary">Tersedia</span></small>
                  </div>
                  @endif
                @endforeach
              </div>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Buat Pesanan</button>
              <a href="{{ route('pemesanan.index') }}" class="btn btn-light" type="submit">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let hargaLapangan = 0; // Variable untuk menyimpan harga lapangan
let selectedJadwals = []; // Menyimpan jadwal yang dipilih

// Ketika tanggal pemesanan berubah
document.getElementById('tanggal_pemesanan').addEventListener('change', function() {
  const tanggalPemesanan = this.value;
  if (tanggalPemesanan) {
    document.getElementById('jam-pemesanan-section').style.display = 'block';
    resetJamPemesanan();
  } else {
    document.getElementById('jam-pemesanan-section').style.display = 'none';
    resetJamPemesanan();
  }
});

function resetJamPemesanan() {
  selectedJadwals = [];
  const jadwalItems = document.querySelectorAll('.jadwal-item');
  jadwalItems.forEach(item => item.classList.remove('selected'));
  calculateTotal();
}

// Ambil detail lapangan
function getLapanganDetail(lapanganId) {
  if (lapanganId) {
    fetch(`/pemesanan/lapangan/detail/${lapanganId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          let gambarHtml = '';
          data.data.gambar_lapangan.forEach(gambar => {
            gambarHtml += `
              <img src="/image/${gambar}" alt="${data.data.nama_lapangan}" class="img-fluid rounded mb-2" style="object-fit: cover; width: 130px; height: 80px" />
            `;
          });

          document.getElementById('lapangan-detail').innerHTML = `
            <div class="d-flex gap-2 justify-content-between flex-wrap">
              ${gambarHtml}
            </div>
            <div class="d-flex flex-column mt-2 gap-2">
              <span><div class="text-muted mb-2 d-flex justify-content-between"><span>Lapangan: </span><span>${data.data.nama_lapangan}</span></div><hr class="my-0" /></span>
              <span><div class="text-muted mb-2 d-flex justify-content-between"><span>Jenis: </span><span>${data.data.jenis_lapangan}</span></div><hr class="my-0" /></span>
              <span><div class="text-muted mb-2 d-flex justify-content-between"><span>Sub harga: </span><span>Rp. ${data.data.harga_lapangan}</span></div><hr class="my-0" /></span>
              <span id="total-harga-section" class="text-muted mb-2 d-flex justify-content-between"><span>Total harga: </span><span>Rp. 0</span></span><hr class="my-0" />
            </div>
          `;
          hargaLapangan = data.data.harga_lapangan;
          document.getElementById('tanggal_pemesanan').disabled = false;
        } else {
          document.getElementById('lapangan-detail').innerHTML = `<p>${data.message}</p>`;
          document.getElementById('tanggal_pemesanan').disabled = true;
        }
      })
      .catch(error => console.error('Error:', error));
  } else {
    document.getElementById('lapangan-detail').innerHTML = '';
    document.getElementById('tanggal_pemesanan').disabled = true;
  }
}

// Toggle pemilihan jadwal
function toggleSelectJadwal(element) {
  const jadwalId = element.getAttribute('data-jadwal-id');
  const isSelected = selectedJadwals.includes(jadwalId);

  if (isSelected) {
    selectedJadwals = selectedJadwals.filter(id => id !== jadwalId);
    element.classList.remove('selected');
  } else {
    selectedJadwals.push(jadwalId);
    element.classList.add('selected');
  }

  document.getElementById('jadwals').value = selectedJadwals;
  calculateTotal();
}

// Hitung total harga
function calculateTotal() {
  const totalJam = selectedJadwals.length;
  const totalHarga = totalJam * parseInt(hargaLapangan.replace(/\./g, ''), 10);

  const formattedTotalHarga = totalHarga.toLocaleString('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  });

  document.querySelector('#total-harga-section span:last-child').innerText = formattedTotalHarga;
}
</script>

@endsection
