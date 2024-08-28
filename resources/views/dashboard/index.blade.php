@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Dashboard</strong> Futsal App</h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="row">
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Pemesanan</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="shopping-bag"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">2.382</h1>
              <div class="mb-0">
                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
                <span class="text-muted">Bulan September</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Pelanggan</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="users"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">120</h1>
              <div class="mb-0">
                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
                <span class="text-muted">Bulan September</span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col mt-0">
                  <h5 class="card-title">Pendapatan</h5>
                </div>

                <div class="col-auto">
                  <div class="stat text-primary">
                    <i class="align-middle" data-feather="dollar-sign"></i>
                  </div>
                </div>
              </div>
              <h1 class="mt-1 mb-3">Rp. 800.000</h1>
              <div class="mb-0">
                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
                <span class="text-muted">Bulan September</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-12 col-xxl-7">
    <div class="card flex-fill w-100">
      <div class="card-header">

        <h5 class="card-title mb-0">Analis Pelanggan</h5>
      </div>
      <div class="card-body py-3">
        <div class="chart chart-sm">
          <canvas id="chartjs-dashboard-line"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection