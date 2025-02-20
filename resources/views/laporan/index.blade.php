@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Download Laporan</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <form class="row g-3" method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
              <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
              <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
            </div>
            <div class="col-md-6">
              <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
              <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
            </div>
            <div class="col-12">
                <button class="btn btn-danger" type="submit" formaction="{{ route('laporan.exportPDF') }}">PDF</button>
                <button class="btn btn-success" type="submit" formaction="{{ route('laporan.exportExcel') }}">EXCEL</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection