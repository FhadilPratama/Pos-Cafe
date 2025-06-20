@extends('layouts.app')

@section('content')
<div class="main">
    <h1 class="section-title">Dashboard POS Café</h1>

    <!-- Quick Stats -->
    <div class="stats-row">
        <div class="card-stat">
            <h3>Penjualan Hari Ini</h3>
            <p>Rp {{ number_format($totalSalesToday, 0, ',', '.') }}</p>
        </div>

        <div class="card-stat">
            <h3>Transaksi Hari Ini</h3>
            <p>{{ $transactionCountToday }}</p>
        </div>

        <div class="card-stat">
            <h3>Produk Terlaris</h3>
            <p>{{ $topMenuName ?? '-' }}</p>
        </div>
    </div>

    <div class="activity-list">
        <h2>Grafik Penjualan 7 Hari Terakhir</h2>
        <canvas id="salesChart" height="120"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($salesDates) !!},
            datasets: [{
                label: 'Penjualan (Rp)',
                data: {!! json_encode($salesAmounts) !!},
                fill: true,
                backgroundColor: 'rgba(210, 180, 140, 0.2)', 
                borderColor: 'rgba(107, 66, 38, 1)', 
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: 'rgba(107, 66, 38, 1)',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: '#6B4226',
                        font: {
                            family: "'Playfair Display', serif",
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
