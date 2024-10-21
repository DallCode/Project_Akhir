@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <!-- Croppie CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
    <style>
        .profile-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .profile-header {
            background: linear-gradient(45deg, #3a7bd5, #00d2ff);
            color: white;
            padding: 30px;
        }

        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            color: #333;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            color: #333;
        }

        .education-item,
        .experience-item {
            border-left: 2px solid #3a7bd5;
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .education-item:before,
        .experience-item:before {
            content: '';
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #3a7bd5;
        }

        .action-buttons {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .education-item:hover .action-buttons,
        .experience-item:hover .action-buttons {
            opacity: 1;
        }

        .skill-tag {
            display: inline-block;
            background-color: #f0f0f0;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
    </style>

    <!-- Croppie JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

    <div class="container mt-5">
        <div class="profile-card">
            <div class="profile-header">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ $perusahaan->logo
                            ? asset('storage/images/' . $perusahaan->logo)
                            : asset('bkk/dist/assets/images/default-company-logo.jpg') }}"
                            class="profile-img rounded-circle" alt="Profile Image">
                        <div class="mt-3">
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editPhotoModal">
                                <i class="bi bi-pencil-fill"></i> Ganti Logo
                            </button>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h2 class="mb-3">
                            <strong>{{ $perusahaan->nama ?? 'N/A' }}</strong>
                            <a href="#" class="text-light ms-2" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kontak:</strong> {{ $perusahaan->no_telepon ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Bidang Usaha:</strong> {{ $perusahaan->bidang_usaha ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Username:</strong> {{ $user->username ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Alamat:</strong> {{ $perusahaan->alamat ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ $perusahaan->status ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk ganti foto --}}
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="profile-picture-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="editPhotoModalLabel">
                            <i class="fas fa-camera me-2"></i>Ganti Logo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="upload-container text-center p-3 border rounded bg-light">
                                    <label for="file-input" class="form-label mb-0">
                                        <div class="upload-prompt cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt fs-3 mb-2"></i>
                                            <p class="mb-0">Klik atau seret foto ke sini</p>
                                            <small class="text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                                        </div>
                                    </label>
                                    <input type="file" class="form-control d-none" id="file-input" name="logo"
                                        accept="image/*" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="preview-container bg-light p-3 rounded" style="display: none;">
                                    <h6 class="mb-3">Sesuaikan Foto</h6>
                                    <div class="text-center">
                                        <img id="image-preview" src="" alt="Preview"
                                            style="display: none; max-width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="canvas" style="display: none;"></canvas>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="button" id="crop-button" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .upload-container {
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .upload-container:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .upload-prompt {
            cursor: pointer;
        }

        .preview-container {
            min-height: 300px;
            margin-top: 20px;
        }

        .cr-viewport {
            box-shadow: 0 0 2000px 2000px rgba(0, 0, 0, 0.5);
            border: 2px solid #fff;
        }

        .cr-boundary {
            background-color: #f8f9fa;
        }

        .modal-content {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
    </style>

    <!-- Modal for editing admin data -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editAdminForm" method="POST"
                    action="{{ route('profileperusahaan.update', $perusahaan->id_data_perusahaan) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data perusahaan </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ $perusahaan->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="bidang_usaha" class="form-label">Bidang Usaha</label>
                            <input type="text" class="form-control" id="bidang_usaha" name="bidang_usaha"
                                value="{{ $perusahaan->bidang_usaha }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $perusahaan->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                value="{{ $perusahaan->no_telepon }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                value="{{ $perusahaan->status }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let croppieInstance;
        const fileInput = document.getElementById('file-input');
        const imagePreview = document.getElementById('image-preview');
        const cropButton = document.getElementById('crop-button');
        const previewContainer = document.querySelector('.preview-container');

        // Ketika file dipilih
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) { // 2MB dalam bytes
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.src = event.target.result;
                    previewContainer.style.display = 'block';

                    // Inisialisasi Croppie
                    if (croppieInstance) {
                        croppieInstance.destroy();
                    }

                    croppieInstance = new Croppie(imagePreview, {
                        viewport: {
                            width: 200,
                            height: 200,
                            type: 'circle'
                        },
                        boundary: {
                            width: 300,
                            height: 300
                        },
                        enableExif: true,
                        enableOrientation: true
                    });
                }
                reader.readAsDataURL(file);
            }
        });

        // Drag and drop functionality
        const uploadContainer = document.querySelector('.upload-container');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadContainer.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadContainer.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadContainer.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            uploadContainer.classList.add('border-primary');
        }

        function unhighlight(e) {
            uploadContainer.classList.remove('border-primary');
        }

        uploadContainer.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }

        // Ketika tombol "Simpan" ditekan
        cropButton.addEventListener('click', function() {
            if (croppieInstance) {
                cropButton.disabled = true;
                cropButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';

                croppieInstance.result({
                    type: 'blob',
                    size: {
                        width: 200,
                        height: 200
                    },
                    format: 'jpeg'
                }).then(function(blob) {
                    const formData = new FormData();
                    formData.append('logo', blob, 'logo.jpg');

                    fetch("{{ route('profileperusahaan.updatePhoto', Auth::user()->perusahaan->id_data_perusahaan) }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal memperbarui logo.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                $('#editPhotoModal').modal('hide');
                                location.reload();
                            } else {
                                alert('Gagal memperbarui logo.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(error.message);
                        })
                        .finally(() => {
                            cropButton.disabled = false;
                            cropButton.innerHTML = '<i class="fas fa-save me-1"></i>Simpan';
                        });
                });
            }
        });
    </script>
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
