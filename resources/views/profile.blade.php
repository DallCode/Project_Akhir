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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
        .education-item, .experience-item {
            border-left: 2px solid #3a7bd5;
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        .education-item:before, .experience-item:before {
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
                        <img src="{{ Auth::user()->alumni->foto
                            ? asset('storage/foto/' . Auth::user()->alumni->foto)
                            : (Auth::user()->alumni->jenis_kelamin == 'Laki Laki'
                                ? asset('bkk/dist/assets/images/faces/4.jpg')
                                : asset('bkk/dist/assets/images/faces/3.jpg')) }}"
                            class="profile-img rounded-circle" alt="Profile Image">
                        <div class="mt-3">
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editPhotoModal">
                                <i class="bi bi-pencil-fill"></i> Ganti Foto
                            </button>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h2 class="mb-3">
                            <strong>{{ Auth::user()->alumni->nama }}</strong>
                            <a href="#" class="text-light ms-2" data-bs-toggle="modal" data-bs-target="#editModal">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kontak:</strong> {{ Auth::user()->alumni->kontak }}</p>
                                <p class="mb-1"><strong>Lokasi:</strong> {{ Auth::user()->alumni->lokasi }}</p>
                                <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ Auth::user()->alumni->jenis_kelamin }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Username:</strong> {{ Auth::user()->username }}</p>
                                <p class="mb-1"><strong>Alamat:</strong> {{ Auth::user()->alumni->alamat }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ Auth::user()->alumni->status }}</p>
                            </div>
                        </div>
                        <a href="{{ route('alumni.exportProfile', Auth::user()->alumni->nik) }}" class="btn btn-light mt-3">
                            Export PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-body">
                <h5 class="section-title">
                    Tentang Saya
                    <a href="#" class="text-primary float-end" data-bs-toggle="modal" data-bs-target="#editAboutModal">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                </h5>
                <p>{{ $user->deskripsi }}</p>
            </div>
        </div>

        <div class="profile-card">
            <div class="card-body">
                <h5 class="section-title d-flex justify-content-between align-items-center">
                    Pendidikan Formal
                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editFormalModal">
                        <i class="bi bi-plus-circle-fill"></i> Tambah
                    </a>
                </h5>
                @foreach ($formal as $f)
                    <div class="education-item">
                        <h6 class="mb-1">{{ $f->nama_sekolah }}</h6>
                        <p class="mb-1"><strong>{{ $f->bidang_studi }}</strong></p>
                        <p class="mb-1">{{ $f->tahun_awal }} - {{ $f->tahun_akhir }}</p>
                        <p class="mb-1">{{ $f->deskripsi }}</p>
                        <div class="action-buttons">
                            <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editFormalModal" data-id="{{ $f->id_riwayat_pendidikan_formal }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteFormal({{ $f->id_riwayat_pendidikan_formal }})">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="profile-card">
            <div class="card-body">
                <h5 class="section-title d-flex justify-content-between align-items-center">
                    Pendidikan Non-Formal
                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editNonFormalModal">
                        <i class="bi bi-plus-circle-fill"></i> Tambah
                    </a>
                </h5>
                @foreach ($nonFormal as $nf)
                    <div class="education-item">
                        <h6 class="mb-1">{{ $nf->nama_lembaga }}</h6>
                        <p class="mb-1"><strong>{{ $nf->kursus }}</strong></p>
                        <p class="mb-1">{{ $nf->tanggal }}</p>
                        <div class="action-buttons">
                            <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editNonFormalModal" data-id="{{ $nf->id_riwayat_pendidikan_non_formal }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteNonFormal({{ $nf->id_riwayat_pendidikan_non_formal }})">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="profile-card">
            <div class="card-body">
                <h5 class="section-title d-flex justify-content-between align-items-center">
                    Keahlian
                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editSkillModal">
                        <i class="bi bi-plus-circle-fill"></i> Tambah
                    </a>
                </h5>
                @foreach ($skill as $s)
                    <span class="skill-tag">
                        {{ $s->keahlian }}
                        <a href="#" class="text-primary ms-2" data-bs-toggle="modal" data-bs-target="#editSkillModal" data-id="{{ $s->nik }}">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="#" class="text-danger ms-1" onclick="deleteSkill({{ $s->nik }})">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    </span>
                @endforeach
            </div>
        </div>

        <div class="profile-card">
            <div class="card-body">
                <h5 class="section-title d-flex justify-content-between align-items-center">
                    Pengalaman Kerja
                    <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#editPengalamanModal">
                        <i class="bi bi-plus-circle-fill"></i> Tambah
                    </a>
                </h5>
                @foreach ($kerja as $k)
                    <div class="experience-item">
                        <h6 class="mb-1">{{ $k->nama_perusahaan }}</h6>
                        <p class="mb-1"><strong>{{ $k->jabatan }}</strong></p>
                        <p class="mb-1">{{ $k->tahun_awal }} - {{ $k->tahun_akhir }}</p>
                        <div class="action-buttons">
                            <a href="#" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editkModal" data-id="{{ $k->id_pengalaman_kerja }}">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteExperience({{ $k->id_pengalaman_kerja }})">
                                <i class="bi bi-trash-fill"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function deleteFormal(id) {
            if (confirm('Apakah anda yakin menghapus data ini?')) {
                fetch(`/delete-pendidikan-formal/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Gagal menghapus data.');
                    }
                }).catch(error => {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }

        function deleteNonFormal(id) {
            if (confirm('Are you sure you want to delete this education record?')) {
                // Implement delete functionality here
            }
        }

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
                            <label for="province">Provinsi</label>
                            <select id="province" name="province" class="form-control" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="city">Kota/Kabupaten</label>
                            <select id="city" name="city" class="form-control" required>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
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

    <script>
        // Menyimpan data provinsi dan kota secara global
        let provincesData = [];
        let citiesData = [];

        // Mengambil data provinsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            fetchProvinces();
        });

        async function fetchProvinces() {
            try {
                const response = await fetch('/get-provinces');
                provincesData = await response.json();

                let provinceSelect = document.getElementById('province');
                provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';

                provincesData.forEach(province => {
                    let option = document.createElement('option');
                    option.value = province.id;
                    option.text = province.name;
                    provinceSelect.add(option);
                });

                // Set nilai provinsi yang sudah ada (jika ada)
                @if($user->alumni && $user->alumni->lokasi)
                    const userLokasi = "{{ $user->alumni->lokasi }}";
                    if (userLokasi) {
                        const [cityName, provinceName] = userLokasi.split(', ').map(item => item.trim());

                        // Cari ID provinsi berdasarkan nama
                        const province = provincesData.find(p => p.name === provinceName);
                        if (province) {
                            provinceSelect.value = province.id;
                            // Trigger change event untuk memuat kota
                            const event = new Event('change');
                            provinceSelect.dispatchEvent(event);
                        }
                    }
                @endif
            } catch (error) {
                console.error('Error fetching provinces:', error);
            }
        }

        // Event listener untuk perubahan provinsi
        document.getElementById('province').addEventListener('change', async function() {
            const provinceId = this.value;
            if (!provinceId) return;

            try {
                const response = await fetch(`/get-cities/${provinceId}`);
                citiesData = await response.json();

                let citySelect = document.getElementById('city');
                citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';

                citiesData.forEach(city => {
                    let option = document.createElement('option');
                    option.value = city.id;
                    option.text = city.name;
                    citySelect.add(option);
                });

                // Set nilai kota yang sudah ada (jika ada)
                @if($user->alumni && $user->alumni->lokasi)
                    const userLokasi = "{{ $user->alumni->lokasi }}";
                    if (userLokasi) {
                        const [cityName, provinceName] = userLokasi.split(', ').map(item => item.trim());

                        // Cari ID kota berdasarkan nama
                        const city = citiesData.find(c => c.name === cityName);
                        if (city) {
                            citySelect.value = city.id;
                        }
                    }
                @endif
            } catch (error) {
                console.error('Error fetching cities:', error);
            }
        });

        // Tambahkan validasi sebelum form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const province = document.getElementById('province').value;
            const city = document.getElementById('city').value;

            if (!province || !city) {
                e.preventDefault();
                alert('Silakan pilih Provinsi dan Kota/Kabupaten');
                return false;
            }
        });
        </script>


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
                            <textarea class="form-control" id="keahlian" name="keahlian" rows="3" required></textarea>
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

    {{-- Modal untuk ganti foto --}}
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="profile-picture-form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="editPhotoModalLabel">
                            <i class="fas fa-camera me-2"></i>Ganti Foto Profil
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
                                    <input type="file" class="form-control d-none" id="file-input" name="foto"
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
                    formData.append('foto', blob, 'profile.jpg');

                    fetch("{{ route('profile.updatePhoto', Auth::user()->alumni->nik) }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal memperbarui foto.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                $('#editPhotoModal').modal('hide');
                                location.reload();
                            } else {
                                alert('Gagal memperbarui foto.');
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
