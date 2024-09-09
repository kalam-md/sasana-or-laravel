@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Profile</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="card">
        <div class="card-body text-center">
          <img 
              id="photo-preview" 
              src="{{ auth()->user()->photo ? asset('profile/' . auth()->user()->photo) : asset('admin/img/avatars/profile.webp') }}" 
              alt="{{ auth()->user()->name ?? 'User Photo' }}" 
              class="img-fluid rounded mb-2" 
              style="object-fit: cover; width: 150px; height: 150px"/
          />
          <h5 class="card-title mb-0">{{ auth()->user()->fullname }}</h5>
          <div class="text-muted mb-2">{{ auth()->user()->role }}</div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
          <h5 class="h6 card-title">Ubah Profile</h5>
          <form class="row g-3" method="post" action="{{ route('profile.update', auth()->user()->username) }}" enctype="multipart/form-data">
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
            <div class="col-md-12">
              <label for="photo" class="form-label">Photo Profile</label>
              <input type="file" class="form-control" value="" id="photo" name="photo" onchange="previewImage()">
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

<script>
  function previewImage() {
      const photoInput = document.getElementById('photo');
      const photoPreview = document.getElementById('photo-preview');
  
      if (photoInput.files && photoInput.files[0]) {
          const reader = new FileReader();
  
          reader.onload = function (e) {
              photoPreview.src = e.target.result;
          }
  
          reader.readAsDataURL(photoInput.files[0]);
      } else {
          // Set default image if no file is selected
          photoPreview.src = '{{ auth()->user()->photo ? asset('uploads/' . auth()->user()->photo) : asset('admin/img/avatars/profile.webp') }}';
      }
  }
</script>

@endsection