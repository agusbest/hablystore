@extends('adminlte::page')

@section('title', 'Edit Barang')

@section('content_header')
<h1>Edit Barang</h1>
@stop

@section('content')

<div class="row justify-content-center">

    <div class="col-12 col-md-8 col-lg-6">

        <div class="card card-primary shadow-sm">

            <div class="card-body">

                <form action="{{ route('products.update', $product->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Brand</label>

                        <input type="text"
                               name="brand"
                               class="form-control"
                               value="{{ $product->brand }}">
                    </div>

                    <div class="form-group">
                        <label>Model</label>

                        <input type="text"
                               name="model"
                               class="form-control"
                               value="{{ $product->model }}">
                    </div>

                    <div class="form-group">
                        <label>RAM</label>

                        <input type="text"
                               name="ram"
                               class="form-control"
                               value="{{ $product->ram }}">
                    </div>

                    <div class="form-group">
                        <label>ROM</label>

                        <input type="text"
                               name="rom"
                               class="form-control"
                               value="{{ $product->rom }}">
                    </div>

                    <div class="form-group">
                        <label>Warna</label>

                        <input type="text"
                               name="color"
                               class="form-control"
                               value="{{ $product->color }}">
                    </div>

                    <div class="d-flex justify-content-between mt-4">

                        <a href="{{ route('products.index') }}"
                           class="btn btn-secondary">

                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>

                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Update
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@stop