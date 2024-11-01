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
                                    <h6 class="text-muted font-semibold">Total Lowongan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalLoker }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <h6 class="text-muted font-semibold">Lowongan Yang Dipublikasi</h6>
                                    <h6 class="font-extrabold mb-0">{{ $lokerDipublikasi }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <h6 class="text-muted font-semibold">Total Lamaran</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalLamaran }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <h6 class="text-muted font-semibold">Lamaran Terbaru</h6>
                                    <h6 class="font-extrabold mb-0">{{ $lamaranTerbaru }}</h6>
                                </div>
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
                            <h4>Lowongan & Lamaran Perbulan</h4>
                            <select id="yearSelector" class="form-select mt-2">
                                <!-- Option years can be dynamically added from backend -->
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <canvas id="jobApplicationsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Lamaran Per Lowongan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="applicationStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const lokerData = @json($lokerPerBulan);
    const lamaranData = @json($lamaranPerBulan);
    const statusData = @json($statusLamaran);

    // Chart for Job Postings and Applications per Month
    const jobApplicationsChartCtx = document.getElementById('jobApplicationsChart').getContext('2d');
    const jobApplicationsChart = new Chart(jobApplicationsChartCtx, {
        type: 'bar',
        data: {
            labels: lokerData.map(item => `Bulan ${item.month}`),
            datasets: [
                {
                    label: 'Jumlah Lowongan',
                    data: lokerData.map(item => item.count),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                },
                {
                    label: 'Jumlah Lamaran',
                    data: lamaranData.map(item => item.count),
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Jumlah Lowongan & Lamaran Perbulan'
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Chart for Application Status per Job Posting
    const applicationStatusChartCtx = document.getElementById('applicationStatusChart').getContext('2d');
    const applicationStatusChart = new Chart(applicationStatusChartCtx, {
        type: 'bar',
        data: {
            labels: statusData.map(item => `Lowongan ID ${item.id_lowongan_pekerjaan}`),
            datasets: [
                {
                    label: 'Total Lamaran',
                    data: statusData.map(item => item.total),
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                },
                {
                    label: 'Diterima',
                    data: statusData.map(item => item.accepted),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Status Lamaran per Lowongan'
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection
