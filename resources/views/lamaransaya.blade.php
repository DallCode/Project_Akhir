@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('bkk/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('bkk/dist/assets/images/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Lamaran</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Simple Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Nama Perusahaan</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lamaranSaya as $lamaran)
                                <tr>
                                    <td>{{ $lamaran->loker->perusahaan->nama }}</td>
                                    <td>{{ $lamaran->loker->jabatan }}</td>
                                    <td>{{ $lamaran->status }}</td>
                                    <td>
                                        <!-- Tombol untuk membuka modal pesan -->
                                        <button class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalPesan{{ $lamaran->id_lamaran }}">
                                            <i class="bi bi-envelope"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Daftar file pesan dalam modal -->
                                <div class="modal fade" id="modalPesan{{ $lamaran->id_lamaran }}" tabindex="-1"
                                    aria-labelledby="modalPesanLabel{{ $lamaran->id_lamaran }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalPesanLabel{{ $lamaran->id_lamaran }}">
                                                    Pesan dari {{ $lamaran->loker->perusahaan->nama }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="list-group">
                                                    @php
                                                        $pesanFiles = Storage::files(
                                                            'public/pesan_lamaran/' . $lamaran->id_lamaran,
                                                        );
                                                    @endphp

                                                    @forelse ($pesanFiles as $file)
                                                        <li class="list-group-item">
                                                            <!-- Mengambil URL pesan dengan Storage::url() -->
                                                            <button class="btn btn-link"
                                                                onclick="bukaPesan('{{ Storage::url($file) }}', '{{ basename($file) }}')">
                                                                {{ basename($file) }}
                                                            </button>
                                                        </li>
                                                    @empty
                                                        <li class="list-group-item">Belum ada pesan dari perusahaan.</li>
                                                    @endforelse
                                                </ul>

                                                <!-- Box untuk menampilkan isi pesan -->
                                                <div id="boxPesan{{ $lamaran->id_lamaran }}" class="mt-3"
                                                    style="display:none;">
                                                    <h6>Isi Pesan:</h6>
                                                    <div class="alert alert-info" id="isiPesan{{ $lamaran->id_lamaran }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Script untuk membuka box pesan -->
    <script>
       function bukaPesan(url, namaFile) {
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('File tidak ditemukan');
            }
            return response.text();
        })
        .then(data => {
            // Ambil elemen box pesan berdasarkan nama file
            const boxPesan = document.getElementById('boxPesan' + namaFile.split('.')[0]);
            const isiPesan = document.getElementById('isiPesan' + namaFile.split('.')[0]);

            if (boxPesan && isiPesan) {
                isiPesan.innerHTML = data;  // Menampilkan isi pesan
                boxPesan.style.display = 'block';  // Menampilkan box pesan
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Pesan tidak dapat dibuka.');
        });
}

    </script>

    <script src="{{ asset('bkk/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bkk/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
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

    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
