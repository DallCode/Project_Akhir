@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.css">
    <style>
        .sky-blue {
            background-color: #87CEEB;
        }

        .orange {
            background-color: #FFA500;
        }

        .pink {
            background-color: #FF69B4;
        }

        .light-green {
            background-color: #90EE90;
        }

        .dark-purple {
            background-color: #800080;
        }

        .yellow {
            background-color: #FFD700;
        }

        .dark-blue {
            background-color: #00008B;
        }
    </style>

    <div class="container-fluid py-4">
        <!-- Welcome Header -->
        <div class="page-heading mb-4">
            <h3 class="fw-bold">
                Selamat Datang,
                <span class="text-primary">
                    @if (Auth::user()->role == 'Alumni')
                        {{ $alumniLogin->nama }}
                    @elseif (Auth::user()->role == 'Admin BKK')
                        {{ Auth::user()->role }}
                    @elseif (Auth::user()->role == 'Perusahaan')
                        {{ $perusahaanLogin->nama }}
                    @endif
                </span>
            </h3>
        </div>

        <div class="page-content">
            <div class="row">
                <!-- Left Column -->
                <div class="col-12 col-lg-9">
                    <!-- Stats Cards Row -->
                    <div class="row g-3 mb-4">
                        <!-- Total Alumni -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon purple p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Alumni</h6>
                                            <h5 class="fw-bold mb-0">{{ $jumlahAlumni }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Perusahaan -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon orange p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Perusahaan</h6>
                                            <h5 class="fw-bold mb-0">{{ $jumlahPerusahaan }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Perusahaan -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon green p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Alumni Bekerja</h6>
                                            <h5 class="fw-bold mb-0">{{ $alumniBekerja }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Perusahaan -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon red p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Alumni Belum Bekerja</h6>
                                            <h5 class="fw-bold mb-0">{{ $alumniBelumBekerja }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Perusahaan -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon blue p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Alumni Kuliah</h6>
                                            <h5 class="fw-bold mb-0">{{ $alumniKuliah }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Total Perusahaan -->
                        <div class="col-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon yellow p-3 me-3">
                                            <i class="iconly-boldProfile text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-muted mb-1">Alumni Wirausaha</h6>
                                            <h5 class="fw-bold mb-0">{{ $alumniWirausaha }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Chart Section -->
                    <div class="card card-round">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Top 10 Perusahaan - Statistik Alumni Diterima</div>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                        <span class="btn-label"><i class="fa fa-pencil"></i></span>
                                        Export
                                    </a>
                                    <a href="#" class="btn btn-label-info btn-round btn-sm">
                                        <span class="btn-label"><i class="fa fa-print"></i></span>
                                        Print
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Dropdown Tahun -->
                            <div class="form-group col-md-2">
                                <label for="yearSelect">Pilih Tahun:</label>
                                <select id="yearSelect" class="form-select">
                                    @for ($year = date('Y'); $year >= date('Y') - 4; $year--)
                                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                            {{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <!-- Chart Container -->
                            <div class="chart-container" style="height: 400px;">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column for Pie Charts -->
                <div class="col-12 col-lg-3">
                    <!-- Total Status Pie Chart -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Tracer Study Keseluruhan</h5>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px;">
                                <canvas id="totalPieChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Department-wise Status Pie Chart -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Tracer Study per Jurusan</h5>
                                <select id="deptSelect" class="form-select form-select-sm" style="width: auto;">
                                    @foreach (['AK', 'BR', 'DKV', 'MLOG', 'MP', 'RPL', 'TKJ'] as $dept)
                                        <option value="{{ $dept }}">{{ $dept }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 250px;">
                                <canvas id="deptPieChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        {{-- Tracer chart seluruh jurusan --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Colors configuration
                const colors = {
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)', // Bekerja
                        'rgba(255, 99, 132, 0.8)', // Belum Bekerja
                        'rgba(54, 162, 235, 0.8)', // Kuliah
                        'rgba(255, 206, 86, 0.8)' // Wirausaha
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ]
                };

                // Chart configuration function
                function createPieChartConfig(data, title) {
                    return {
                        type: 'pie',
                        data: {
                            labels: ['Bekerja', 'Belum Bekerja', 'Kuliah', 'Wirausaha'],
                            datasets: [{
                                data: data,
                                backgroundColor: colors.backgroundColor,
                                borderColor: colors.borderColor,
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12,
                                        font: {
                                            size: 11
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: title,
                                    font: {
                                        size: 13
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.parsed || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((value * 100) / total).toFixed(1);
                                            return `${label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    };
                }

                // Initialize Total Status Pie Chart
                const totalStatusData = @json($totalStatusCounts);
                const totalCtx = document.getElementById('totalPieChart').getContext('2d');
                new Chart(totalCtx, createPieChartConfig([
                    totalStatusData.Bekerja,
                    totalStatusData['Belum Bekerja'],
                    totalStatusData.Kuliah,
                    totalStatusData.Wirausaha
                ], 'Distribusi Status Alumni'));

                // Department-wise Pie Chart
                const statusCounts = @json($statusCounts);
                let deptPieChart;

                function updateDeptPieChart(department) {
                    const data = statusCounts[department];
                    const ctx = document.getElementById('deptPieChart').getContext('2d');

                    if (deptPieChart) {
                        deptPieChart.destroy();
                    }

                    deptPieChart = new Chart(ctx, createPieChartConfig([
                        data.Bekerja,
                        data['Belum Bekerja'],
                        data.Kuliah,
                        data.Wirausaha
                    ], `Status Alumni - ${department}`));
                }

                // Initialize with first department
                updateDeptPieChart('AK');

                // Department selector event handler
                document.getElementById('deptSelect').addEventListener('change', function(event) {
                    updateDeptPieChart(event.target.value);
                });
            });
        </script>
        {{-- Tracer chart per jurusan --}}
        <script>
            // Add Pie Chart Configuration
            document.addEventListener('DOMContentLoaded', function() {
                const statusCounts = @json($statusCounts);
                let pieChart;

                function updatePieChart(department) {
                    const data = statusCounts[department];
                    const ctx = document.getElementById('pieChart').getContext('2d');

                    const config = {
                        type: 'pie',
                        data: {
                            labels: ['Bekerja', 'Belum Bekerja', 'Kuliah', 'Wirausaha'],
                            datasets: [{
                                data: [
                                    data.Bekerja,
                                    data['Belum Bekerja'],
                                    data.Kuliah,
                                    data.Wirausaha
                                ],
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.8)',
                                    'rgba(255, 99, 132, 0.8)',
                                    'rgba(54, 162, 235, 0.8)',
                                    'rgba(255, 206, 86, 0.8)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        boxWidth: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: `Status Alumni - ${department}`,
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    };

                    if (pieChart) {
                        pieChart.destroy();
                    }
                    pieChart = new Chart(ctx, config);
                }

                // Initialize with first department
                updatePieChart('AK');

                // Department selector event handler
                document.getElementById('deptSelect').addEventListener('change', function(event) {
                    updatePieChart(event.target.value);
                });
            });
        </script>

        <script>
            // Toast Notifications
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

            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('barChart').getContext('2d');
                var myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Alumni Diterima',
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgb(54, 162, 235)',
                            borderWidth: 2,
                            data: @json($values)
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `Jumlah Diterima: ${context.raw} Alumni`;
                                    }
                                }
                            }
                        }
                    }
                });

                // Fungsi untuk memperbarui data grafik berdasarkan tahun
                async function updateChartData(year) {
                    try {
                        const response = await fetch(`/get-accepted-stats/${year}`);
                        const data = await response.json();

                        myBarChart.data.labels = data.labels;
                        myBarChart.data.datasets[0].data = data.values;
                        myBarChart.update();
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    }
                }

                // Event listener untuk dropdown tahun
                document.getElementById('yearSelect').addEventListener('change', function(event) {
                    updateChartData(event.target.value);
                });
            });
        </script>
    @endsection
