@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    {{-- Untuk menampilkan data Profile --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Profile</h5>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <img src="{{ asset('bkk/dist/assets/images/faces/apdal.jpg') }}" class="rounded-circle"
                            alt="Profile Image" style="width: 200px; height: 200px; object-fit: cover;">
                    </div>

                    <div class="col-md-8">
                        <h2><strong>{{ $user->nama }}</strong> <a href="#" class="text-primary"
                                data-bs-toggle="modal" data-bs-target="#editModal">
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
                                <p><strong>USERNAME</strong></p>
                                <p class="text-muted">{{ $user->username }}</p>

                                <p><strong>ALAMAT LENGKAP</strong></p>
                                <p class="text-muted">{{ $user->alamat }}</p>

                                <p><strong>STATUS</strong></p>
                                <p class="text-muted">{{ $user->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Untuk menampilkan About --}}
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

    {{-- Untuk menampilkan Pendidikan Formal --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Pendidikan Formal</h5>
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editFormalModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pendidikan Formal
            </a>
        </div>
        <div class="card-body">
            @foreach ($formal as $f)
                <div class="education-item position-relative mb-3">
                    <h6 class="mb-1">{{ $f->nama_sekolah }}</h6>
                    <p class="mb-1"><strong>{{ $f->bidang_studi }}</strong></p>
                    <p class="mb-1">{{ $f->tahun_awal }} - {{ $f->tahun_akhir }}</p>
                    <p class="mb-1">{{ $f->deskripsi }}</p>
                    <div class="education-actions position-absolute top-0 end-0 d-none">
                        <a href="#" class="text-primary me-2" data-bs-toggle="modal" data-bs-target="#editFormalModal"
                            data-id="{{ $f->id_riwayat_pendidikan_formal }}">
                            <i class="bi bi-pencil-fill">Edit</i>
                        </a>
                        <a href="#" class="text-danger"
                            onclick="deleteFormal({{ $f->id_riwayat_pendidikan_formal }})">
                            <i class="bi bi-trash-fill"> Hapus</i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .education-item:hover .education-actions {
            display: block !important;
        }
    </style>

    <script>
        function deleteFormal(id) {
            if (confirm('Are you sure you want to delete this education record?')) {
                // Implement delete functionality here
            }
        }
    </script>

    {{-- Untuk menampilkan Pendidikan Non Formal --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Pendidikan Non-Formal</h5>
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editNonFormalModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pendidikan Non Formal
            </a>
        </div>
        <div class="card-body">
            @foreach ($nonFormal as $nf)
                <div class="education-item position-relative mb-3">
                    <h6 class="mb-1">{{ $nf->nama_lembaga }}</h6>
                    <p class="mb-1"><strong>{{ $nf->kursus }}</strong></p>
                    <p class="mb-1">{{ $nf->tanggal }}</p>

                    <div class="education-actions position-absolute top-0 end-0 d-none">
                        <a href="#" class="text-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#editNonFormalModal" data-id="{{ $nf->id_riwayat_pendidikan_non_formal }}">
                            <i class="bi bi-pencil-fill">Edit</i>
                        </a>
                        <a href="#" class="text-danger"
                            onclick="deleteNonFormal({{ $nf->id_riwayat_pendidikan_non_formal }})">
                            <i class="bi bi-trash-fill"> Hapus</i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .education-item:hover .education-actions {
            display: block !important;
        }
    </style>

    <script>
        function deleteNonFormal(id) {
            if (confirm('Are you sure you want to delete this education record?')) {
                // Implement delete functionality here
            }
        }
    </script>

    {{-- Section untuk Menampilkan Keahlian --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Keahlian</h5>
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editSkillModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Keahlian
            </a>
        </div>
        <div class="card-body">
            @foreach ($skill as $s)
                <div class="education-item position-relative mb-3">
                    <h6 class="mb-1">{{ $s->keahlian }}</h6>
                    <div class="education-actions position-absolute top-0 end-0 d-none">
                        <a href="#" class="text-primary me-2" data-bs-toggle="modal" data-bs-target="#editSkillModal"
                            data-id="{{ $s->nik }}">
                            <i class="bi bi-pencil-fill">Edit</i>
                        </a>
                        <a href="#" class="text-danger" onclick="deleteSkill({{ $s->nik }})">
                            <i class="bi bi-trash-fill"> Hapus</i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .education-item:hover .education-actions {
            display: block !important;
        }
    </style>

    <script>
        function deleteSkill(id) {
            if (confirm('Are you sure you want to delete this skill?')) {
                fetch(`/delete-skill/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            }
        }
    </script>

    {{-- Untuk menampilkan Pengalaman Kerja --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Pengalaman Kerja</h5>
            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editPengalamanModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Pengalaman Kerja
            </a>
        </div>
        <div class="card-body">
            @foreach ($kerja as $k)
                <div class="experience-item position-relative mb-3">
                    <h6 class="mb-1">{{ $k->nama_perusahaan }}</h6>
                    <p class="mb-1"><strong>{{ $k->jabatan }}</strong></p>
                    <p class="mb-1">{{ $k->tahun_awal }} - {{ $k->tahun_akhir }}</p>
                    <div class="k-actions position-absolute top-0 end-0 d-none">
                        <a href="#" class="text-primary me-2" data-bs-toggle="modal" data-bs-target="#editkModal"
                            data-id="{{ $k->id_pengalaman_kerja }}">
                            <i class="bi bi-pencil-fill">Edit</i>
                        </a>
                        <a href="#" class="text-danger" onclick="deleteExperience({{ $k->id_pengalaman_kerja }})">
                            <i class="bi bi-trash-fill"> Hapus</i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .experience-item:hover .experience-actions {
            display: block !important;
        }
    </style>

    <script>
        function deleteExperience(id) {
            if (confirm('Are you sure you want to delete this work experience record?')) {
                // Implement delete functionality here
            }
        }
    </script>




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
    <div class="modal fade" id="editModal" tabindex="-1" data-bs-backdrop="static" role="dialog"
        aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal untuk Edit dan Tambah Pendidikan Formal --}}
    <div class="modal fade" id="editFormalModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="editFormalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFormalModalLabel">
                        {{ isset($editMode) ? 'Edit Pendidikan' : 'Tambah Pendidikan' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formalEducationForm" method="POST"
                        action="{{ isset($editMode) ? route('update.pendidikan.formal', $formal->id_riwayat_pendidikan_formal) : route('store.pendidikan.formal') }}">
                        @csrf
                        @if (isset($editMode))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="tingkat_pendidikan" class="form-label">Tingkat Pendidikan</label>
                            <select class="form-select" id="tingkat_pendidikan" name="tingkat_pendidikan" required>
                                <option value="">Pilih Tingkat Pendidikan</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA/SMK">SMA/SMK</option>
                                <option value="D1">Diploma (D1 - D4)</option>
                                <option value="S1">Sarjana (S1)</option>
                                <option value="S2">Magister (S2)</option>
                                <option value="S3">Doktor (S3)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_sekolah" class="form-label">Institusi</label>
                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" required
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="bidang_studi" class="form-label">Bidang Studi</label>
                            <input type="text" class="form-control" id="bidang_studi" name="bidang_studi">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun_awal" class="form-label">Tahun Mulai</label>
                                <input type="number" class="form-control" id="tahun_awal" name="tahun_awal" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tahun_akhir" class="form-label">Tahun Selesai</label>
                                <input type="number" class="form-control" id="tahun_akhir" name="tahun_akhir" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Institusi</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <div class="mb-3">
                            <label for="gelar" class="form-label">Gelar (Opsional)</label>
                            <input type="text" class="form-control" id="gelar" name="gelar">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Informasi Tambahan (Opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editFormalModal');
            const tingkatPendidikanSelect = document.getElementById('tingkat_pendidikan');
            const namaSekolahInput = document.getElementById('nama_sekolah');
            const bidangStudiInput = document.getElementById('bidang_studi');
            const tahunAwalInput = document.getElementById('tahun_awal');
            const tahunAkhirInput = document.getElementById('tahun_akhir');
            const alamatInput = document.getElementById('alamat');
            const gelarInput = document.getElementById('gelar');
            const deskripsiInput = document.getElementById('deskripsi');

            // Function to toggle nama_sekolah input based on tingkat_pendidikan selection
            function toggleNamaSekolahInput() {
                namaSekolahInput.disabled = !tingkatPendidikanSelect.value; // Enable input if a level is selected
                if (!tingkatPendidikanSelect.value) {
                    namaSekolahInput.value = ''; // Clear the input if disabled
                }
            }

            // Initialize the state of the input based on the current selection
            toggleNamaSekolahInput();

            tingkatPendidikanSelect.addEventListener('change', toggleNamaSekolahInput);

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id'); // Get ID from the button data attribute
                const form = this.querySelector('#formalEducationForm');
                const title = this.querySelector('.modal-title');

                // Clear previous hidden method input if it exists
                const existingMethodField = form.querySelector('input[name="_method"]');
                if (existingMethodField) {
                    existingMethodField.remove();
                }

                if (id) {
                    // Edit mode
                    title.textContent = 'Edit Pendidikan';
                    form.action = `/update-pendidikan-formal/${id}`; // Correct route for update
                    form.method = 'POST'; // Form method should be POST

                    // Add hidden input for PUT method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT'; // Indicate that it is a PUT request
                    form.appendChild(methodField);

                    // Fetch and populate data
                    fetchEducationData(id);
                } else {
                    // Add mode
                    title.textContent = 'Tambah Pendidikan';
                    form.action = '/store-pendidikan-formal'; // Correct route for store
                    form.method = 'POST'; // Use POST for new entries
                    form.reset(); // Reset the form
                    toggleNamaSekolahInput(); // Reset nama_sekolah input state
                }
            });

            function fetchEducationData(id) {
                // Simulate fetch data (you need to replace this with the appropriate AJAX call)
                fetch(`/get-pendidikan-formal/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form with fetched data
                        tingkatPendidikanSelect.value = data.tingkat_pendidikan;
                        toggleNamaSekolahInput(); // Update state of nama_sekolah input
                        namaSekolahInput.value = data.nama_sekolah;
                        bidangStudiInput.value = data.bidang_studi;
                        tahunAwalInput.value = data.tahun_awal;
                        tahunAkhirInput.value = data.tahun_akhir;
                        alamatInput.value = data.alamat;
                        gelarInput.value = data.gelar;
                        deskripsiInput.value = data.deskripsi;
                    })
                    .catch(error => console.error('Error fetching education data:', error));
            }
        });
    </script>

    {{-- Modal untuk Edit dan Tambah Pendidikan Non Formal --}}
    <div class="modal fade" id="editNonFormalModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="editNonFormalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNonFormalModalLabel">
                        {{ isset($editMode) ? 'Edit Pendidikan' : 'Tambah Pendidikan' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nonFormalEducationForm" method="POST"
                        action="{{ isset($editMode) ? route('update.pendidikan.nonformal', $nonFormal->id_riwayat_pendidikan_non_formal) : route('store.pendidikan.nonformal') }}">
                        @csrf
                        @if (isset($editMode))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="nama_lembaga" class="form-label">Nama Lembaga</label>
                            <input type="text" class="form-control" id="nama_lembaga" name="nama_lembaga" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <div class="mb-3">
                            <label for="kursus" class="form-label">Kursus</label>
                            <input type="text" class="form-control" id="kursus" name="kursus" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editNonFormalModal');
            const namaLembagaInput = document.getElementById('nama_lembaga');
            const alamatInput = document.getElementById('alamat');
            const kursusInput = document.getElementById('kursus');
            const tanggalInput = document.getElementById('tanggal');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = this.querySelector('#nonFormalEducationForm');
                const title = this.querySelector('.modal-title');

                const existingMethodField = form.querySelector('input[name="_method"]');
                if (existingMethodField) {
                    existingMethodField.remove();
                }

                if (id) {
                    title.textContent = 'Edit Pendidikan';
                    form.action = `/update-pendidikan-nonformal/${id}`;
                    form.method = 'POST';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);

                    fetchNonFormalData(id);
                } else {
                    title.textContent = 'Tambah Pendidikan';
                    form.action = '/store-pendidikan-nonformal';
                    form.method = 'POST';
                    form.reset();
                }
            });

            function fetchNonFormalData(id) {
                fetch(`/get-pendidikan-nonformal/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        namaLembagaInput.value = data.nama_lembaga;
                        alamatInput.value = data.alamat;
                        kursusInput.value = data.kursus;
                        tanggalInput.value = data.tanggal;
                    })
                    .catch(error => console.error('Error fetching education data:', error));
            }
        });
    </script>

    {{-- Modal untuk Edit dan Tambah Keahlian --}}
    <div class="modal fade" id="editSkillModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="editSkillModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSkillModalLabel">
                        {{ isset($editMode) ? 'Edit Keahlian' : 'Tambah Keahlian' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="skillForm" method="POST"
                        action="{{ isset($editMode) ? route('update.skill', $skill->nik) : route('store.skill') }}">
                        @csrf
                        @if (isset($editMode))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="keahlian" class="form-label">Keahlian</label>
                            <input type="text" class="form-control" id="keahlian" name="keahlian" required>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editSkillModal');
            const keahlianInput = document.getElementById('keahlian');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const form = this.querySelector('#skillForm');
                const title = this.querySelector('.modal-title');

                const existingMethodField = form.querySelector('input[name="_method"]');
                if (existingMethodField) {
                    existingMethodField.remove();
                }

                if (id) {
                    title.textContent = 'Edit Keahlian';
                    form.action = `/update-skill/${id}`;
                    form.method = 'POST';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    form.appendChild(methodField);

                    fetchSkillData(id);
                } else {
                    title.textContent = 'Tambah Keahlian';
                    form.action = '/store-skill';
                    form.method = 'POST';
                    form.reset();
                }
            });

            function fetchSkillData(id) {
                fetch(`/get-skill/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        keahlianInput.value = data.keahlian;
                    })
                    .catch(error => console.error('Error fetching skill data:', error));
            }
        });
    </script>

    {{-- Modal untuk Edit dan Tambah Pengalaman Kerja --}}
    <div class="modal fade" id="editPengalamanModal" tabindex="-1" data-bs-backdrop="static"
        aria-labelledby="editPengalamanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengalamanModalLabel">
                        {{ isset($editMode) ? 'Edit Pengalaman Kerja' : 'Tambah Pengalaman Kerja' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pengalamanKerjaForm" method="POST"
                        action="{{ isset($editMode) ? route('update.pengalaman.kerja', $pengalamanKerja->id_pengalaman_kerja) : route('store.pengalaman.kerja') }}">
                        @csrf
                        @if (isset($editMode))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_waktu_pekerjaan" class="form-label">Jenis Waktu Pekerjaan</label>
                            <select class="form-select" id="jenis_waktu_pekerjaan" name="jenis_waktu_pekerjaan" required>
                                <option value="">Pilih Jenis Waktu Pekerjaan</option>
                                <option value="Waktu Kerja Standar (Full-Time)">Waktu Kerja Standar (Full-Time)</option>
                                <option value="Waktu Kerja Paruh Waktu (Part-Time)">Waktu Kerja Paruh Waktu (Part-Time)
                                </option>
                                <option value="Waktu Kerja Fleksibel (Flexible Hours)">Waktu Kerja Fleksibel (Flexible
                                    Hours)</option>
                                <option value="Shift Kerja (Shift Work)">Shift Kerja (Shift Work)</option>
                                <option value="Waktu Kerja Bergilir (Rotating Shifts)">Waktu Kerja Bergilir (Rotating
                                    Shifts)</option>
                                <option value="Waktu Kerja Jarak Jauh (Remote Work)">Waktu Kerja Jarak Jauh (Remote Work)
                                </option>
                                <option value="Waktu Kerja Kontrak (Contract Work)">Waktu Kerja Kontrak (Contract Work)
                                </option>
                                <option value="Waktu Kerja Proyek (Project-Based Work)">Waktu Kerja Proyek (Project-Based
                                    Work)</option>
                                <option value="Waktu Kerja Tidak Teratur (Irregular Hours)">Waktu Kerja Tidak Teratur
                                    (Irregular Hours)</option>
                                <option value="Waktu Kerja Sementara (Temporary Work)">Waktu Kerja Sementara (Temporary
                                    Work)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Perusahaan</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun_awal" class="form-label">Tahun Mulai</label>
                                <input type="number" class="form-control" id="tahun_awal" name="tahun_awal" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tahun_akhir" class="form-label">Tahun Selesai</label>
                                <input type="number" class="form-control" id="tahun_akhir" name="tahun_akhir" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan (Opsional)</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('editPengalamanModal');
            const jabatanInput = document.getElementById('jabatan');
            const jenisWaktuInput = document.getElementById('jenis_waktu_pekerjaan');
            const namaPerusahaanInput = document.getElementById('nama_perusahaan');
            const alamatInput = document.getElementById('alamat');
            const tahunAwalInput = document.getElementById('tahun_awal');
            const tahunAkhirInput = document.getElementById('tahun_akhir');
            const deskripsiInput = document.getElementById('deskripsi');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id'); // Get ID from the button data attribute
                const form = this.querySelector('#pengalamanKerjaForm');
                const title = this.querySelector('.modal-title');

                // Clear previous hidden method input if it exists
                const existingMethodField = form.querySelector('input[name="_method"]');
                if (existingMethodField) {
                    existingMethodField.remove();
                }

                if (id) {
                    // Edit mode
                    title.textContent = 'Edit Pengalaman Kerja';
                    form.action = `/update-pengalaman-kerja/${id}`; // Correct route for update
                    form.method = 'POST'; // Form method should be POST

                    // Add hidden input for PUT method
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT'; // Indicate that it is a PUT request
                    form.appendChild(methodField);

                    // Fetch and populate data
                    fetchPengalamanData(id);
                } else {
                    // Add mode
                    title.textContent = 'Tambah Pengalaman Kerja';
                    form.action = '/store-pengalaman-kerja'; // Correct route for store
                    form.method = 'POST'; // Use POST for new entries
                    form.reset(); // Reset the form
                }
            });

            function fetchPengalamanData(id) {
                fetch(`/get-pengalaman-kerja/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form with fetched data
                        jabatanInput.value = data.jabatan;
                        jenisWaktuInput.value = data.jenis_waktu_pekerjaan;
                        namaPerusahaanInput.value = data.nama_perusahaan;
                        alamatInput.value = data.alamat;
                        tahunAwalInput.value = data.tahun_awal;
                        tahunAkhirInput.value = data.tahun_akhir;
                        deskripsiInput.value = data.deskripsi;
                    })
                    .catch(error => console.error('Error fetching pengalaman data:', error));
            }
        });
    </script>










    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: 'right',
                backgroundColor: "#4CAF50",
                stopOnFocus: true,
            }).showToast();
        @endif
    </script>
@endsection
