@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Profile</h5>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('bkk/dist/assets/images/faces/intan.jpg') }}" class="rounded-circle"
                             alt="Profile Image" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>
                    
                    <div class="col-md-8">
                        <h2><strong>{{ $user->nama }}</strong> <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="bi bi-pencil-fill"></i>
                        </a> </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>KONTAK</strong></p>
                                <p class="text-muted">{{ $user->kontak }}</p>

                                <p><strong>LOKASI</strong></p>
                                <p class="text-muted">{{ $user->lokasi }}</p>

                                <p><strong>JENIS KELAMIN</strong></p>
                                <p class="text-muted">{{ $user->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>USERNAME</span></strong></p>
                                <p class="text-muted">{{ $user->username }}</p>

                                <p><strong>ALAMAT LENGKAP</strong></p>
                                <p class="text-muted">{{ $user->alamat }}</p>

                                <p><strong>PENGALAMAN KERJA</strong></p>
                                <p class="text-muted">{{ $user->pengalaman_kerja ?? 'Belum ada pengalaman kerja' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Pendidikan Formal
                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editFormalModal">
                    <i class="bi bi-pencil-fill"></i>
                </a>
            </h5>
            @foreach ($formal as $f)
    
            <p>{{ $f->nama_sekolah }}</p>

            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Tentang Saya
                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                    <i class="bi bi-pencil-fill"></i>
                </a>
            </h5>
            <p>{{ $user->deskripsi }}</p>
        </div>
    </div>

    <!-- Modal Edit Tentang Saya -->
    <div class="modal fade" id="editAboutModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="editAboutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('update.about') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAboutModalLabel">Edit Tentang Saya</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5">{{ $user->deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ $user->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="kontak">Kontak</label>
                            <input type="text" class="form-control" id="kontak" name="kontak"
                                value="{{ $user->kontak }}" required>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <textarea class="form-control" id="lokasi" name="lokasi" placeholder="kota, provinsi">{{ $user->lokasi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" name="alamat" required>{{ $user->alamat }}</textarea>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top", // 'top' or 'bottom'
                position: 'right', // 'left', 'center' or 'right'
                backgroundColor: "#4CAF50",
                stopOnFocus: true, // Prevents dismissing of toast on hover
            }).showToast();
        @endif
    </script>
@endsection
