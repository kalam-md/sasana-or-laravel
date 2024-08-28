@extends('layouts.main')

@section('content')

<h1 class="h3 mb-3"><strong>Jadwal</strong></h1>

<div class="row">
  <div class="col-12 d-flex">
    <div class="w-100">
      <div class="row">
        <div class="col-12 d-flex">
          <div class="card flex-fill table-responsive">
            <table class="table table-hover table-bordered my-0">
              <thead>
                <tr>
                  <th class="d-none d-xl-table-cell">Jam Main</th>
                  <th class="d-none d-xl-table-cell">Aktif</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($jadwals as $jadwal)
                  <tr>
                    <td>
                      {{ $jadwal->jam }}
                    </td>
                    <td>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $jadwal->id }}" id="jadwal-{{ $jadwal->id }}" style="width: 25px; height: 25px"
                        @if($jadwal->aktif) checked @endif
                        onchange="updateJadwalStatus({{ $jadwal->id }})" />
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

<script>
  function updateJadwalStatus(id) {
    let checkbox = document.getElementById('jadwal-' + id);
    let status = checkbox.checked ? 1 : 0;

    // Kirimkan request ke server
    fetch('/update-jadwal-status/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            aktif: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Status berhasil diupdate');
        } else {
            console.log('Gagal mengupdate status');
        }
    })
    .catch(error => console.error('Error:', error));
  }
</script>