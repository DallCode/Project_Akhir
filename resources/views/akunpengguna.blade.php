@extends('layout.main')

@section('content')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

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
                    <h3>Data Alumni</h3>
                    <p class="text-subtitle text-muted">For user to check their list</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Data Pengguna</li>
                            <li class="breadcrumb-item active" aria-current="page">Data Alumni</li>
                            <li class="breadcrumb-item active" aria-current="page">Lihat Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-center">
                    <a href="#" class="btn btn-outline-primary btn-lg me-4 w-50"><i class="bi bi-person-plus"></i>
                        Tambah Akun Perusahaan</a>
                    <a href="{{ route('tambahadmin') }}" class="btn btn-outline-success btn-lg w-50"><i
                            class="bi bi-person-plus"></i> Tambah Akun Admin</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h5>Filter Data</h5>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label>Role</label>
                            <select class="form-select" id="roleFilter">
                                <option value="">Semua Role</option>
                                @php
                                    $roles = $users->pluck('role')->unique();
                                @endphp
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $us)
                                <tr>
                                    <td>{{ $us->username }}</td>
                                    <td>{{ $us->role }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editPasswordModal{{ $us->username }}">
                                            Edit
                                        </button>

                                        <!-- Modal for password change -->
                                        <div class="modal fade" id="editPasswordModal{{ $us->username }}" tabindex="-1"
                                            data-bs-backdrop="false"
                                            aria-labelledby="editPasswordModalLabel{{ $us->username }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="editPasswordModalLabel{{ $us->username }}">
                                                            Edit Password: {{ $us->username }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('updatePassword', $us->username) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="password{{ $us->username }}"
                                                                    class="form-label">New Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="password{{ $us->username }}" name="password"
                                                                    required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password_confirmation{{ $us->username }}"
                                                                    class="form-label">Confirm Password</label>
                                                                <input type="password" class="form-control"
                                                                    id="password_confirmation{{ $us->username }}"
                                                                    name="password_confirmation" required>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

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
                gravity: "top", // 'top' or 'bottom'
                position: 'right', // 'left', 'center' or 'right'
                backgroundColor: "{{ session('success') ? '#4CAF50' : '#F44336' }}", // Hijau untuk success, Merah untuk error
                stopOnFocus: true, // Prevents dismissing of toast on hover
            }).showToast();

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const password = form.querySelector('input[name="password"]').value;
                    const confirmPassword = form.querySelector('input[name="password_confirmation"]').value;

                    if (password !== confirmPassword) {
                        e.preventDefault();
                        alert('Password dan Konfirmasi Password tidak cocok!');
                    }
                });
            });
        @endif
    </script>

    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        document.getElementById('roleFilter').addEventListener('change', filterData);

        function filterData() {
            const role = document.getElementById('roleFilter').value;
            let searchQuery = [];

            if (role) searchQuery.push(role);

            // Filter based on the values
            if (searchQuery.length > 0) {
                dataTable.search(searchQuery.join(' ')).draw();
            } else {
                dataTable.search('').draw(); // Clear the search if no filters are applied
            }
        }
    </script>

    <script src="{{ asset('bkk/dist/assets/js/main.js') }}"></script>
@endsection
