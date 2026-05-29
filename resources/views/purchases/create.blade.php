@extends('adminlte::page')

@section('title', 'Transaksi Penjualan')

@section('content_header')
    <h1>Transaksi Penjualan</h1>
@stop

@section('content')

<div class="row">

    {{-- LIST PRODUK --}}
    <div class="col-md-4">

        <div class="card card-primary card-outline">

            <div class="card-header">

                <h3 class="card-title">
                    List Produk Ready
                </h3>

            </div>

            <div class="card-body p-2">

                <input
                    type="text"
                    id="search_product"
                    class="form-control mb-2"
                    placeholder="Cari produk..."
                >

                <div
                    style="
                        max-height:550px;
                        overflow-y:auto;
                   "
                >
                    <!-- <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody id="product_table">
                            @foreach($products as $product)
                                @php
                                    $readyUnits = $product->units
                                        ->where('status_stok', 'ready');
                                @endphp
                                @if($readyUnits->count() > 0)
                                <tr class="product-row">
                                    <td>
                                        <strong>
                                            {{ $product->brand }}
                                            {{ $product->model }}
                                        </strong>
                                        <br>
                                        RAM:
                                        {{ $product->ram }}
                                        |
                                        ROM:
                                        {{ $product->rom }}
                                        <br>
                                        {{ $product->color }}
                                        |
                                        IMEI:
                                        {{ $product->imei1 }}
                                       
                                        

                                    </td>

                                    <td align="center">

                                        <span class="badge bg-success">

                                            {{ $readyUnits->count() }}

                                        </span>

                                    </td>

                                </tr>

                                @endif

                            @endforeach

                        </tbody>

                    </table> -->
<tbody id="product_table">

    @foreach($products as $product)

        @php
            $readyUnits = $product->units
                ->where('status_stok', 'ready');
        @endphp

        @if($readyUnits->count() > 0)

        <tr class="product-row">

            {{-- PRODUK --}}
            <td width="90%">

                <strong>
                    {{ $product->brand }}
                    {{ $product->model }}
                </strong>

                <br>

                RAM:
                {{ $product->ram }}

                |

                ROM:
                {{ $product->rom }}

                :

                {{ $product->color }}

                <br>

                <strong>IMEI:</strong>

                <table
                    width="100%"
                    class="table table-sm table-borderless mb-0"
                >

                    @foreach($readyUnits as $unit)

                    <tr>

                        <td>

                            {{ $unit->imei1 }}

                        </td>

                    </tr>

                    @endforeach

                </table>

            </td>

            {{-- TOTAL STOK --}}
            <!-- <td
                align="center"
                width="10%"
            >

                <span class="badge bg-primary">

                    {{ $readyUnits->count() }}

                </span>

            </td> -->

        </tr>

        @endif

    @endforeach

</tbody>

                </div>

            </div>

        </div>

    </div>

    {{-- FORM TRANSAKSI --}}
    <div class="col-md-8">

        <div class="card">

            <div class="card-body">

                <form
                    action="{{ route('sales.store') }}"
                    method="POST"
                >

                    @csrf

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Customer</label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    class="form-control"
                                    placeholder="Nama Customer"
                                >

                            </div>

                        </div>

                    </div>

                    <hr>

                    {{-- INPUT IMEI --}}
                    <div class="form-group">

                        <label>
                            Scan / Input IMEI
                        </label>

                        <input
                            type="text"
                            id="imei_input"
                            class="form-control form-control-lg"
                            placeholder="Scan IMEI di sini..."
                            autofocus
                        >

                        <small class="text-muted">
                            Bisa scan barcode scanner atau ketik manual lalu ENTER
                        </small>

                    </div>

                    {{-- HASIL PRODUK --}}
                    <div
                        id="product_result"
                        style="display:none;"
                    >

                        <div class="alert alert-info">

                            <h5 id="product_name"></h5>

                            <p class="mb-1">

                                IMEI :
                                <span id="imei_text"></span>

                            </p>

                            <p class="mb-0">

                                Harga :
                                Rp
                                <span id="harga_text"></span>

                            </p>

                        </div>

                    </div>

                    <input
                        type="hidden"
                        name="product_unit_id"
                        id="product_unit_id"
                    >

                    <hr>

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>Harga Jual</label>

                                <input
                                    type="number"
                                    name="sell_price"
                                    id="sell_price"
                                    class="form-control"
                                    required
                                >

                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="form-group">

                                <label>Bayar</label>

                                <input
                                    type="number"
                                    name="paid_amount"
                                    id="paid_amount"
                                    class="form-control"
                                    required
                                >

                            </div>

                        </div>

                    </div>

                    <button
                        class="btn btn-primary"
                    >

                        <i class="fas fa-save"></i>

                        Simpan Transaksi

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@stop

@section('js')

<script>

    // =========================
    // SEARCH PRODUK
    // =========================

    $('#search_product').on('keyup', function(){

        let value = $(this)
            .val()
            .toLowerCase();

        $('.product-row').filter(function(){

            $(this).toggle(

                $(this)
                    .text()
                    .toLowerCase()
                    .indexOf(value) > -1

            );

        });

    });

    // =========================
    // SCAN IMEI
    // =========================

    $('#imei_input').keypress(function(e){
        if(e.which == 13){
            e.preventDefault();
            let imei = $(this).val();
            if(imei == ''){
                alert('IMEI kosong');
                return;
            }
            $.ajax({
                url: "{{ route('sales.findUnit') }}",
                type: "GET",
                data: {
                    imei: imei
                },
                success: function(res){
                    if(res.success){
                        $('#product_result').show();
                        $('#product_name')
                            .text(res.unit.product_name);
                        $('#imei_text')
                            .text(res.unit.imei1);
                        $('#harga_text')
                            .text(
                                Number(res.unit.sell_price)
                                .toLocaleString('id-ID')
                            );
                        $('#sell_price')
                            .val(res.unit.sell_price);
                        $('#paid_amount')
                            .val(res.unit.sell_price);
                        $('#product_unit_id')
                            .val(res.unit.id);
                        $('#imei_input')
                            .val('');
                    }else{

                        alert(
                            'IMEI tidak ditemukan / sudah terjual'
                        );

                    }

                },

                error:function(){

                    alert('Terjadi kesalahan server');

                }

            });

        }

    });

</script>

@stop