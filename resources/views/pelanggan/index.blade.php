@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Pelanggan</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="row">
        <div class="col-12 d-flex">
          <div class="card flex-fill">
            <table class="table table-hover my-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Pelanggan</th>
                  <th class="d-none d-xl-table-cell">Email</th>
                  <th class="d-none d-xl-table-cell">Role</th>
                  <th class="d-none d-md-table-cell text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <img src="{{ $user->photo ? asset('profile/' . $user->photo) : asset('admin/img/avatars/profile.webp') }}" alt="{{ $user->fullname }}" 
                      class="img-fluid rounded shadow" 
                      style="object-fit: cover; width: 80px; height: 80px">
                      {{ $user->fullname }}
                    </td>
                    <td class="d-none d-xl-table-cell">{{ $user->email }}</td>
                    <td class="d-none d-xl-table-cell">{{ $user->role }}</td>
                    <td class="d-none d-md-table-cell text-center">
                        <div class="d-flex justify-content-center align-items-center gap-1">
                            <a href="#">
                                <i data-feather="eye" class="text-primary"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Data masih kosong</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection