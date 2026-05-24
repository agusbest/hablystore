@extends('adminlte::page')
@section('title', 'Tambah Barang')
@section('content_header')
<h1>Tambah Barang</h1>
@stop

@section('content')

<form action="{{ route('products.store') }}"
      method="POST">

@csrf

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card shadow-sm">
            <div class="card-body">

                <div class="form-group">
                    <label>Merk</label>
                    <input type="text"
                        name="brand"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>Tipe</label>
                    <input type="text"
                        name="model"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>RAM</label>
                    <input type="text"
                        name="ram"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>ROM</label>
                    <input type="text"
                        name="rom"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label>Warna</label>
                    <input type="text"
                        name="color"
                        class="form-control">
                </div>
        
                <button class="btn btn-success mt-3">
                    Simpan
            </button>
            </div>
        </div>
          </div>
        </div>

    </div>
</div>
</form>

@stop