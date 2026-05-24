<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// Halaman Pertama Tampil

public function index()
{
    // STOK READY
    $stokReady = ProductUnit::where(
        'status_stok',
        'ready'
    )->count();

    // NILAI BARANG READY
    $nilaiBarang = ProductUnit::where(
            'status_stok',
            'ready'
        )
        ->sum('buy_price');

    // TOTAL ITEM TERJUAL
    $itemTerjual = SalesDetail::count();

    // NILAI TERJUAL
    $nilaiTerjual = Sale::sum(
        'grand_total'
    );

    // PROFIT
    $profit = ProductUnit::where(
            'status_stok',
            'sold'
        )
        ->selectRaw(
            // 'SUM(sell_price - buy_price) as total_profit'
            'SUM(buy_price - sell_price) as total_profit'
        )
        ->value('total_profit');

    // GRAFIK PENJUALAN BULANAN
      $chartData = array_fill(1, 12, 0);

    $sales = Sale::selectRaw(
            'MONTH(created_at) as bulan,
            SUM(grand_total) as total'
        )
        ->groupBy('bulan')
        ->get();

    foreach ($sales as $sale) {

        $chartData[$sale->bulan] = $sale->total;
    }

    return view(
        'dashboard',
        compact(
            'stokReady',
            'nilaiBarang',
            'itemTerjual',
            'nilaiTerjual',
            'profit',
            'chartData'
        )
    );
}

}
