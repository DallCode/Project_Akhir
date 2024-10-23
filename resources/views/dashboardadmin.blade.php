@extends('layout.main')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">


<div class="page-heading">
    <h3>Selamat Datang, <span class="text-blue">
        @if (Auth::user()->role == 'Alumni')
            {{ $alumniLogin->nama }}
        @elseif (Auth::user()->role == 'Admin BKK')
            {{ Auth::user()->role }}
        @elseif (Auth::user()->role == 'Perusahaan')
            {{ $perusahaanLogin->nama }}
        @endif
    </span></h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <!-- Total Alumni -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Alumni</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahAlumni }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Total Perusahaan -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Perusahaan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $jumlahPerusahaan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Alumni Bekerja -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Bekerja</h6>
                                    <h6 class="font-extrabold mb-0">{{ $alumniBekerja }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Alumni Belum Bekerja -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Belum Bekerja</h6>
                                    <h6 class="font-extrabold mb-0">{{ $alumniBelumBekerja }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Alumni Kuliah -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon yellow">
                                        <i class="iconly-boldStudy"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Kuliah</h6>
                                    <h6 class="font-extrabold mb-0">{{ $alumniKuliah }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Alumni Wirausaha -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon orange">
                                        <i class="iconly-boldWork"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Wirausaha</h6>
                                    <h6 class="font-extrabold mb-0">{{ $alumniWirausaha }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Ajuan Loker -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon teal">
                                        <i class="iconly-boldWork"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Ajuan Loker</h6>
                                    <h6 class="font-extrabold mb-0">{{ $ajuanLoker }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Visit</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Messages Column -->
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4>Laporan</h4>
                </div>
                <div class="card-content pb-4">
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/4.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Hank Schrader</h5>
                            <h6 class="text-muted mb-0">@johnducky</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/5.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">Dean Winchester</h5>
                            <h6 class="text-muted mb-0">@imdean</h6>
                        </div>
                    </div>
                    <div class="recent-message d-flex px-4 py-3">
                        <div class="avatar avatar-lg">
                            <img src="assets/images/faces/1.jpg">
                        </div>
                        <div class="name ms-4">
                            <h5 class="mb-1">John Dodol</h5>
                            <h6 class="text-muted mb-0">@dodoljohn</h6>
                        </div>
                    </div>
                    <div class="px-4">
                        <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>Lihat Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('barChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels), // Mengirimkan data label dari controller
                datasets: [{
                    label: 'Alumni Masuk Perusahaan',
                    backgroundColor: 'rgba(23, 125, 255, 0.7)',
                    borderColor: 'rgb(23, 125, 255)',
                    borderWidth: 2,
                    data: @json($values) // Mengirimkan data nilai dari controller
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            min: 0,
                            stepSize: 1
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltips: {
                    enabled: true
                },
                animation: {
                    duration: 500,
                    easing: 'linear',
                }
            }
        });

        // Fungsi untuk memperbarui data grafik berdasarkan tahun yang dipilih
        function updateChartData(year) {
            // Implementasikan logika jika Anda perlu mengubah data saat tahun dipilih
        }

        // Event listener untuk dropdown tahun
        document.getElementById('yearSelect').addEventListener('change', function(event) {
            var selectedYear = event.target.value;
            updateChartData(selectedYear);
        });

        // Initial load
        updateChartData(document.getElementById('yearSelect').value);
    });
    </script>
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
