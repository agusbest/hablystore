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
                   id="salesForm"
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. HP</label>
                                <input
                                    type="text"
                                    name="customer_phone"
                                    class="form-control"
                                    placeholder="No. HP Customer"
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
                    <div class="card mt-3">
                    <div class="card-header">
                        <h5>
                            Keranjang Penjualan
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>IMEI</th>
                                        <th>Harga</th>
                                        <th width="50">#</th>
                                    </tr>
                                </thead>
                                <tbody id="cart_body">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">
                                            TOTAL
                                        </th>
                                        <th colspan="2" id="grand_total">
                                            Rp 0
                                       </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                    <input
                        type="hidden"
                        name="product_unit_id"
                        id="product_unit_id"
                    >
                    <hr>
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
                   <div class="row mt-3">

                    <div class="col-6">
                        <button
                            class="btn btn-primary w-100"
                        >
                            <i class="fas fa-save"></i>
                            Simpan Transaksi
                        </button>
                    </div>

                    <div class="col-6">
                        <button
                            type="button"
                            onclick="cancelTransaction()"
                            class="btn btn-warning w-100"
                        >
                            <i class="fas fa-times"></i>
                            Batal Transaksi
                        </button>
                    </div>

                </div>
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

            $.ajax({

                url: "{{ route('sales.addCart') }}",

                type: "POST",

                data: {

                    _token : "{{ csrf_token() }}",
                    imei   : imei

                },

                success:function(res){

                    if(res.success){

                        renderCart(res.cart);

                        $('#imei_input').val('');

                    }else{

                        alert(res.message ?? 'IMEI tidak ditemukan');

                    }

                }

            });

        }

    });


function renderCart(cart)
{
    let html = '';
    let total = 0;

    cart.forEach(function(item, index){

        total += parseFloat(item.sell_price);

        html += `
        <tr>

            <td>
                <strong>${item.product_name}</strong>
                <br>
                RAM: ${item.ram}
                | ROM: ${item.rom}
                | ${item.color}
                | ${item.category_type ?? ''}
            </td>

            <td>
                ${item.imei1}
            </td>

            <td width="180">

                <input
                    type="number"
                    class="form-control form-control-sm text-end item-price"
                    value="${item.sell_price}"
                    data-imei="${item.imei1}"
                >

            </td>

            <td align="center">

                <button
                    onclick="removeCart('${item.imei1}')"
                    type="button"
                    class="btn btn-danger btn-sm"
                >
                    X
                </button>

            </td>

        </tr>
        `;

    });

    $('#cart_body').html(html);

    calculateTotal();

    // event input harga
    $('.item-price').on('input', function(){

        calculateTotal();

    });

    // simpan saat selesai ketik
    $('.item-price').on('change', function(){

        let imei = $(this).data('imei');
        let price = $(this).val();

        updatePrice(imei, price);

    });
}

function calculateTotal()
{
    let total = 0;

    $('.item-price').each(function(){

        total += parseFloat($(this).val()) || 0;

    });

    $('#grand_total').html(
        'Rp ' + Number(total).toLocaleString('id-ID')
    );
}



function updatePrice(imei, price)
{
    $.ajax({
        url: '/sales/update-price',
        type: 'POST',
        data: {
            imei: imei,
            sell_price: price,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res){

            renderCart(res.cart);

        }
    });
}

function removeCart(imei)
{
    $.ajax({
        url: '/sales/remove-cart',
        type: 'POST',
        data: {
            imei: imei,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {

            if(res.success){

                renderCart(res.cart);

            } else {

                alert(res.message);
            }
        }
    });
}

function cancelTransaction()
{
    if(confirm('Batalkan transaksi?')){

        $.post('/sales/clear-cart', {
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function(res){

            renderCart([]);

        });

    }
}


$('#salesForm').submit(function(e){

    e.preventDefault();

    $.ajax({

        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),

        success: function(res){

        // console.log(res);

        if(res.success){

            alert('Transaksi berhasil');

            renderCart([]);

            $('#salesForm')[0].reset();

        } else {

            alert('Gagal simpan transaksi');
            console.log(res.message);
        }

    },

        error: function(xhr){

            console.log(xhr);
            alert('Terjadi kesalahan server');
        }

    });

});

</script>

@stop