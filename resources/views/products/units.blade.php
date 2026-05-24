<div class="card">

    <div class="card-header">
        <h4>
            {{ $product->brand }}
            {{ $product->model }}
            {{ $product->ram }}/{{ $product->rom }}
        </h4>
    </div>
    <div class="card-body">
        <a
            href="{{ route('products.index') }}"
            class="btn btn-secondary mb-3"
        >
            Kembali
        </a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>IMEI</th>
                    <th>Harga Modal</th>
                    <th>Harga Jual</th>
                    <th>Kategori</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($units as $key => $unit)
                <tr>
                    <td>
                        {{ $key + 1 }}
                    </td>
                    <td>
                        {{ $unit->imei1 }}
                    </td>
                    <td>
                        Rp
                        {{ number_format($unit->buy_price) }}
                    </td>
                    <td>
                        Rp
                        {{ number_format($unit->sell_price) }}
                    </td>
                    <td>
                        {{ $unit->category_type }}
                    </td>
                    <td>
                        <span class="badge bg-success">
                            {{ $unit->status_stok }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada stok
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>