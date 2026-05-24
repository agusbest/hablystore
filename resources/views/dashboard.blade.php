@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">

            <div class="inner">
                <h3>
                    {{ number_format($stokReady, 0, ',', '.') }}
                </h3>

                <p>Stok Ready</p>
            </div>

            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>

        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">

            <div class="inner">
                <h3>
                    Rp {{ number_format($nilaiBarang, 0, ',', '.') }}
                </h3>

                <p>Nilai Barang</p>
            </div>

            <div class="icon">
                <i class="fas fa-wallet"></i>
            </div>

        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">

            <div class="inner">
                <h3>
                    {{ number_format($itemTerjual, 0, ',', '.') }}
                </h3>

                <p>Item Terjual</p>
            </div>

            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>

        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">

            <div class="inner">
                <h3>
                    Rp {{ number_format($nilaiTerjual, 0, ',', '.') }}
                </h3>

                <p>Nilai Terjual</p>
            </div>

            <div class="icon">
                <i class="fas fa-cash-register"></i>
            </div>

        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-4">

        <div class="small-box bg-danger">

            <div class="inner">
                <h3>
                    Rp {{ number_format($profit, 0, ',', '.') }}
                </h3>

                <p>Total Profit</p>
            </div>

            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    Grafik Penjualan
                </h3>
            </div>

            <div class="card-body">

                <div style="height:320px;">
                    <canvas id="salesChart"></canvas>
                </div>

            </div>

        </div>

    </div>

</div>

@stop

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById(
    'salesChart'
);

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Ags',
            'Sep',
            'Okt',
            'Nov',
            'Des'
        ],

        datasets: [{

            label: 'Penjualan',

            data: @json(array_values($chartData)),

            borderWidth: 1,
            borderRadius: 6

        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        scales: {

            y: {
                beginAtZero: true
            }

        }

    }

});

</script>

@stop