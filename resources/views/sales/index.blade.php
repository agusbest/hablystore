@extends('adminlte::page')

@section('title', 'Data Penjualan')

@section('content_header')
<h1>Data Penjualan</h1>
@stop

@section('content')

<div class="card">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

            <form action="{{ route('sales.index') }}"
                  method="GET"
                  class="mb-2">

                <div class="input-group">

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari invoice/customer..."
                           value="{{ request('search') }}">

                    <div class="input-group-append">

                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>

                    </div>

                </div>

            </form>

            <a href="{{ route('sales.create') }}"
               class="btn btn-primary mb-2">

                <i class="fas fa-plus"></i>
                Tambah Penjualan

            </a>

        </div>

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="close"
                    data-dismiss="alert">

                <span>&times;</span>

            </button>

        </div>

        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th width="70">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($sales as $sale)
                    <tr class="bg-light">
                        <td>
                            <b>{{ $sale->invoice_number }}</b>
                        </td>
                        <td>
                            {{ date('d-m-Y', strtotime($sale->created_at)) }}
                        </td>
                        <td>
                            {{ $sale->customer_name ?? '-' }}
                        </td>
                        <td>
                            <b>
                                Rp {{ number_format($sale->grand_total) }}
                            </b>
                        </td>
                        <td class="text-center text-nowrap">

                            <a href="{{ route('sales.print', $sale->id) }}"
                            target="_blank"
                            class="btn btn-success btn-xs"
                            title="Print Faktur">

                                <i class="fas fa-print"></i>

                            </a>

                        </td>
                        <td colspan="5" class="p-0">
                  
                    </tr>

                    {{-- DETAIL ITEM --}}
                    <tr>

                        <td colspan="5" class="p-0">

                            <table class="table table-sm mb-0">

                                <thead class="bg-secondary">

                                    <tr>
                                        <th width="50">No</th>
                                        <th>Produk</th>
                                        <th>IMEI</th>
                                        <th>Harga</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($sale->details as $i => $detail)
                                    <tr>
                                        <td>
                                            {{ $i + 1 }}
                                        </td>
                                        <td>
                                            {{ $detail->product->brand ?? '-' }}
                                            {{ $detail->product->model ?? '' }}
                                        </td>
                                        <td>
                                            {{ $detail->imei1 }}
                                        </td>

                                        <td>
                                            Rp {{ number_format($detail->price) }}
                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center">

                            Tidak ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3 d-flex justify-content-center">

            {{ $sales->appends(request()->query())->links() }}

        </div>

    </div>

</div>

@stop