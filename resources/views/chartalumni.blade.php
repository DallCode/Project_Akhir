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
    <canvas id="lamaranChart" style="width: 100%; height: 400px;"></canvas>
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

    document.addEventListener('DOMContentLoaded', function() {
        fetch('/path-to-get-user-lamaran-data')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.loker);
                const jumlah = data.map(item => item.jumlah);

                const ctx = document.getElementById('lamaranChart').getContext('2d');
                const lamaranChart = new Chart(ctx, {
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
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    });
</script>
@endsection
