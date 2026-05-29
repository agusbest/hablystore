@extends('adminlte::page')

@section('title', 'Barang')

@section('content_header')
    <h1>Data Barang</h1>
@stop
@section('css')
<link rel="shortcut icon" href="{{ asset('hablystore.ico') }}">
@stop
@section('content')

<!-- <div class="mb-3">
    <a href="{{ route('products.create') }}"
       class="btn btn-primary">
        Tambah Barang
    </a>
</div> -->
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

            <form action="{{ route('products.index') }}"
                  method="GET"
                  class="mb-2">

                <div class="input-group">

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari barang..."
                           value="{{ request('search') }}">

                    <div class="input-group-append">
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>

                </div>
            </form>

            <a href="{{ route('products.create') }}"
               class="btn btn-primary mb-2">
                <i class="fas fa-plus"></i>
                Tambah Barang
            </a>

        </div>

<div class="card">
    <div class="card-body">
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
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>RAM</th>
                        <th>ROM</th>
                        <th>Warna</th>
                        <th>Stok</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->brand }}</td>
                        <td>{{ $product->model }}</td>
                        <td>{{ $product->ram }}</td>
                        <td>{{ $product->rom }}</td>
                        <td>{{ $product->color }}</td>
                        <td>
                            <span class="badge badge-success">
                                {{ $product->stok }}
                            </span>
                        </td>

                      <td class="text-center text-nowrap">

                            <button
                                class="btn btn-info btn-xs btn-units"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->brand }} {{ $product->model }}"
                                title="List Product"
                            >
                                <i class="fas fa-list"></i>
                            </button>

                            <a href="{{ route('products.edit', $product->id) }}"
                            class="btn btn-warning btn-xs"
                            title="Edit">

                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-xs"
                                        onclick="return confirm('Hapus data?')"
                                        title="Hapus">

                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
                  <div class="mt-3 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>

            </div>
        </div>

    </div>
</div>

{{-- MODAL --}}
<div class="modal fade"
     id="modalUnits"
     tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Product
                </h5>

                <button type="button"
                        class="close"
                        data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>IMEI</th>
                            <th>Harga Modal</th>
                            <th>Harga Jual</th>
                            <th>Kategori</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody id="unitsBody">
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

@stop

@section('js')

<script>

$(document).on('click', '.btn-units', function(){
    let id   = $(this).data('id');
    let name = $(this).data('name');
    $('.modal-title').html(
        'Detail Product : ' + name
    );
    $('#unitsBody').html(`
        <tr>
            <td colspan="6" class="text-center">
                Loading...
            </td>
        </tr>
    `);

    $('#modalUnits').modal('show');
    $.get('/products/' + id + '/units', function(res){
        let html = '';
        if(res.length == 0){
            html += `
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada stok
                    </td>
                </tr>
            `;
        }else{
            $.each(res, function(i, item){
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${item.imei1}</td>
                        <td>
                            Rp ${parseInt(item.buy_price)
                                .toLocaleString()}
                        </td>
                        <td>
                            Rp ${parseInt(item.sell_price)
                                .toLocaleString()}
                        </td>
                        <td>${item.category_type}</td>
                        <td>
                            <span class="badge badge-success">
                                ${item.status_stok}
                            </span>
                        </td>
                    </tr>
                `;
            });
        }
        $('#unitsBody').html(html);
   });
});

</script>

@stop