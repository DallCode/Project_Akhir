@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <div class="container mt-5">
        <h2>Tambah Data Admin</h2>
        <div class="card mt-4">
            <div class="card-header">
                <h5 id="formTitle">Form Informasi Diri</h5>
            </div>
            <div class="card-body">
                <form id="adminForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="step1">
                        <div class="row">
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" name="foto" id="foto" />
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="nip" name="nip" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki Laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kontak" class="form-label">Kontak</label>
                                    <input type="text" class="form-control" id="kontak" name="kontak" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="nextButton" class="btn btn-primary">Selanjutnya</button>
                    </div>

                    <div id="step2" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="email" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="prevButton" class="btn btn-secondary">Kembali</button>
                        <button type="submit" class="btn btn-primary">Tambah Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Register the image preview plugin
        FilePond.registerPlugin(FilePondPluginImagePreview);

        // Create a FilePond instance
        FilePond.create(document.querySelector('input[id="foto"]'), {
            server: {
                process: {
                    url: '{{ route('upload.foto') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                revert: null,
                restore: null,
                load: null,
                fetch: null,
            },
            allowImagePreview: true,
            imagePreviewHeight: 170,
            credits: false
        });

        @if (session('success') || session('error'))
            Toastify({
                text: "{{ session('success') ? session('success') : session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: 'right',
                backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}",
                stopOnFocus: true,
            }).showToast();
        @endif

        // Form step handling
        document.addEventListener('DOMContentLoaded', function() {
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const nextButton = document.getElementById('nextButton');
            const prevButton = document.getElementById('prevButton');
            const formTitle = document.getElementById('formTitle');

            nextButton.addEventListener('click', function() {
                if (validateStep1()) {
                    step1.style.display = 'none';
                    step2.style.display = 'block';
                    formTitle.textContent = 'Form Informasi Akun';
                }
            });

            prevButton.addEventListener('click', function() {
                step2.style.display = 'none';
                step1.style.display = 'block';
                formTitle.textContent = 'Form Informasi Diri';
            });

            function validateStep1() {
                const requiredFields = step1.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    Toastify({
                        text: "Harap isi semua field yang diperlukan",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: 'right',
                        backgroundColor: "#F44336",
                        stopOnFocus: true,
                    }).showToast();
                }

                return isValid;
            }
        });
    </script>
@endsection
