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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Statistik Lamaran Pekerjaan</h4>
                    <div class="card-header-action">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <select id="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="lamaranChart" style="width: 100%; height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Card untuk menampilkan total lamaran -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon purple mb-2">
                                <i class="bi bi-file-text"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Total Lamaran</h6>
                            <h6 class="font-extrabold mb-0" id="totalLamaran">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon blue mb-2">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Lamaran Diterima</h6>
                            <h6 class="font-extrabold mb-0" id="lamaranDiterima">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                            <div class="stats-icon red mb-2">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Lamaran Ditolak</h6>
                            <h6 class="font-extrabold mb-0" id="lamaranDitolak">0</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    let lamaranChart = null;

    function updateChart(bulan, tahun) {
        const url = new URL('{{ route("getUserLamaranData") }}', window.location.origin);
        if (bulan) url.searchParams.append('bulan', bulan);
        if (tahun) url.searchParams.append('tahun', tahun);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Update chart
                const labels = data.chartData.map(item => item.loker);
                const jumlah = data.chartData.map(item => item.jumlah);

                if (lamaranChart) {
                    lamaranChart.destroy();
                }

                const ctx = document.getElementById('lamaranChart').getContext('2d');
                lamaranChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Lamaran per Lowongan',
                            data: jumlah,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Grafik Lamaran Pekerjaan'
                            }
                        }
                    }
                });

                // Update statistics
                document.getElementById('totalLamaran').textContent = data.stats.total;
                document.getElementById('lamaranDiterima').textContent = data.stats.Diterima;
                document.getElementById('lamaranDitolak').textContent = data.stats.Ditolak;
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateChart('', '');

        document.getElementById('bulan').addEventListener('change', function() {
            updateChart(this.value, document.getElementById('tahun').value);
        });

        document.getElementById('tahun').addEventListener('change', function() {
            updateChart(document.getElementById('bulan').value, this.value);
        });
    });
</script>
@endsection