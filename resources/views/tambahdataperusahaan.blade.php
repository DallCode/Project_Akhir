@extends('layout.main')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

<div class="container">
    <h2>Tambah Data Perusahaan</h2>

    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="card mt-4">
        <div class="card-header">
            <h5>Form Tambah Perusahaan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tambahdataperusahaan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>

                <div class="mb-3">
                    <label for="bidang_usaha" class="form-label">Bidang Usaha</label>
                    <input type="text" class="form-control" id="bidang_usaha" name="bidang_usaha" required>
                </div>

                <div class="mb-3">
                    <label for="no_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Tambah Perusahaan</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    @if (session('success') || session('error'))
        Toastify({
            text: "{{ session('success') ? session('success') : session('error') }}",
            duration: 3000,
            close: true,
            gravity: "top", // 'top' or 'bottom'
            position: 'right', // 'left', 'center' or 'right'
            backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}", // Hijau untuk success, Merah untuk error
            stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast();
    @endif
</script>
@endsection
