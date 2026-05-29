<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    //  public function index()
    // {
    //     $sales = Sale::latest()->get();
    //     return view('sales.index', compact('sales'));
    // }
    public function index(Request $request)
    {
        $search = $request->search;

        $sales = Sale::with([
            'details.product'
        ])
        ->when($search, function($q) use ($search){

            $q->where('invoice_number', 'like', "%{$search}%")
            ->orWhere('customer_name', 'like', "%{$search}%");

        })
        ->latest()
        ->paginate(10);

        return view(
            'purchases.index',
            compact('sales')
        );
    }
    

    // public function create()
    // {
    //     $products = Product::withCount([
    //         'units as stok' => function ($q) {
    //             $q->where('status_stok', 'ready');
    //         }
    //     ])->get();
    //     return view('sales.create', compact('products'));
    // }
    public function create()
    {
        $products = Product::with('units')->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
         DB::beginTransaction();

    try {

        // 1. simpan pembelian
        $purchase = Purchase::create([
            'supplier_name' => $request->supplier_name,
            'total' => $request->total
        ]);

        // 2. loop item
        foreach ($request->items as $item) {

            // simpan detail item
            $purchase->items()->create([
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
            ]);

            // 3. UPDATE STOK (INI INTI)
            $product = ProductUnit::find($item['id']);
            $product->stok += $item['qty'];
            $product->save();
        }

        DB::commit();

        return redirect()->route('purchases.index')
            ->with('success', 'Pembelian berhasil & stok masuk gudang');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
    }

    public function findUnit(Request $request)
{
    $imei = $request->imei;

    $unit = ProductUnit::with('product')

        ->where('imei1', $imei)

        ->where('status_stok', 'ready')

        ->first();

    if (!$unit) {

        return response()->json([
            'success' => false
        ]);
    }

    return response()->json([

        'success' => true,

        'unit' => [

            'id' => $unit->id,

            'imei1' => $unit->imei1,

            'sell_price' => $unit->sell_price,

            'product_name' =>

                $unit->product->brand . ' ' .
                $unit->product->model . ' ' .
                $unit->product->ram . '/' .
                $unit->product->rom,

        ]

    ]);
}

public function print($id)
{
    $sale = Sale::with([
        'details.productUnit',
        'details.product'
    ])->findOrFail($id);

    return view('sales.print', compact('sale'));
}

private function generateInvoice()
{
    $date = now()->format('Ymd');
    $last = Sale::whereDate('created_at', now())
        ->latest('id')
        ->first();
    if ($last) {
        $lastNumber = (int) substr($last->invoice_number, -4);
        $nextNumber = $lastNumber + 1;
    } else {
        $nextNumber = 1;
    }

    return 'FP-' . $date . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
}

}
