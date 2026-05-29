@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>
@stop
@section('css')
<link rel="shortcut icon" href="{{ asset('hablystore.ico') }}">
<style>

/* ===== SMALL BOX FIX GLOBAL ===== */
.small-box {
    overflow: hidden;
}

/* angka utama desktop */
.small-box h3 {
    font-size: 26px;
    line-height: 1.1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* text bawah */
.small-box p {
    font-size: 13px;
    white-space: nowrap;
}

/* icon default */
.small-box .icon {
    font-size: 55px;
    opacity: 0.2;
}

/* ===== MOBILE FIX ===== */
@media (max-width: 768px) {

    .small-box {
        min-height: 90px;
    }

    .small-box h3 {
        font-size: 16px !important;
        white-space: normal !important;
        word-break: break-word;
        line-height: 1.2;
    }

    .small-box p {
        font-size: 11px !important;
        white-space: normal;
    }

    .small-box .icon {
        font-size: 35px;
        opacity: 0.15;
    }

    .col-6 {
        padding-left: 5px;
        padding-right: 5px;
    }
}

</style>
@stop

@php
function formatShort($number) {
    if ($number >= 1000000000) {
        return round($number/1000000000, 1).' M';
    } elseif ($number >= 1000000) {
        return round($number/1000000, 1).' JT';
    } elseif ($number >= 1000000) {
        return round($number/1000, 1).' K';
    }
    return $number;
}
@endphp


@section('content')
<div class="container-fluid">
<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">

            <div class="inner">
                <h3>
                    {{ number_format($stokReady, 0, ',', '.') }} unit
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
                     Rp {{ formatShort($nilaiBarang) }}
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
                    {{ number_format($itemTerjual, 0, ',', '.') }} unit
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
                     Rp {{ formatShort($nilaiTerjual) }}
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
                     Rp {{ formatShort($profit) }}
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