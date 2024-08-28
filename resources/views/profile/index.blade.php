@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Profile</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{ asset('admin/img/avatars/avatar.jpg') }}" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" />
          <h5 class="card-title mb-0">{{ auth()->user()->fullname }}</h5>
          <div class="text-muted mb-2">{{ auth()->user()->role }}</div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
          <h5 class="h6 card-title">Ubah Profile</h5>
          <form class="row g-3" method="post" action="{{ route('lapangan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-6">
              <label for="fullname" class="form-label">Nama Lengkap</label>
              <input type="text" class="form-control" value="{{ auth()->user()->fullname }}" id="fullname" name="fullname">
            </div>
            <div class="col-md-6">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" value="{{ auth()->user()->username }}" id="username" name="username">
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" value="{{ auth()->user()->email }}" id="email" name="email">
            </div>
            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit">Simpan</button>
              <a href="{{ route('dashboard') }}" class="btn btn-light" type="submit">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection