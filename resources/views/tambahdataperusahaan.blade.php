@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <div class="container">
        <h2>Tambah Data Perusahaan</h2>
        <div class="card mt-4">
            <div class="card-header">
                <h5>Form Tambah Perusahaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tambahdataperusahaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="logo" class="form-label">Logo Perusahaan</label>
                        <input type="file" id="logo" class="filepond" name="logo" accept="image/*" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama perusahaan" required>
                        </div>

                        <div class="col-md-6">
                            <label for="no_telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" placeholder="Masukkan nomor telepon" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bidang_usaha" class="form-label">Bidang Usaha</label>
                            <input type="text" class="form-control" id="bidang_usaha" name="bidang_usaha" placeholder="Masukkan bidang usaha" required>
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" placeholder="Masukkan provinsi" required>
                        </div>

                        <div class="col-md-6">
                            <label for="kota" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota" placeholder="Masukkan kota" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" placeholder="Masukkan kecamatan" required>
                        </div>

                        <div class="col-md-6">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <input type="text" class="form-control" id="kelurahan" name="kelurahan" placeholder="Masukkan kelurahan" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Tambah Perusahaan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Upload Perusahaan</h5>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="alert-container"></div>
                        <form id="importForm" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" id="file" class="filepond" />
                            <button type="submit" class="btn btn-primary mt-3">Upload and Import</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <script>
            // Register the image preview plugin
            FilePond.registerPlugin(FilePondPluginImagePreview);

            // Create a FilePond instance for logo upload
            FilePond.create(document.querySelector('input[id="logo"]'), {
                server: {
                    process: {
                        url: '{{ route('upload.image') }}',
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

            // Register FilePond instance
            const pond = FilePond.create(document.querySelector('input[id="file"]'), {
                server: {
                    process: {
                        url: '{{ route('upload.file') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000, // Tambahkan timeout untuk mencegah stuck terlalu lama
                        onload: (response) => {
                            try {
                                console.log('Server response:', response); // Debug log
                                return JSON.parse(response).fileName;
                            } catch (error) {
                                console.error('Error parsing response:', error);
                                showAlert('Error parsing server response', 'danger');
                            }
                        },
                        onerror: (response) => {
                            const error = JSON.parse(response);
                            console.error('Upload error:', error);
                            showAlert(error.error || 'An error occurred during file upload', 'danger');
                        }
                    },
                    revert: null,
                    restore: null,
                    load: null,
                    fetch: null,
                },
                allowMultiple: false,
                credits: false
            });

            // Handle form submission
            document.getElementById('importForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Get the file name from FilePond
                const files = pond.getFiles();
                if (files.length === 0) {
                    showAlert('Silahkan pilih file untuk diimpor.', 'danger');
                    return;
                }
                const fileName = files[0].serverId;

                // Send import request
                fetch('{{ route('importdata.perusahaan') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            file: fileName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Import response:', data); // Debug log
                        showAlert(data.alert, data.alert_type);
                        if (data.alert_type === 'success') {
                            pond.removeFile();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('An error occurred during import. Please check the console for more details.',
                            'danger');
                    });
            });

            function showAlert(message, type) {
                const alertContainer = document.getElementById('alert-container');
                alertContainer.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            }



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
        </script>
    @endsection
