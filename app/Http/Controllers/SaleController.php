<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Sale;
use App\Models\SalesDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
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
            'sales.index',
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
            $sale = Sale::create([
                // 'invoice_number' => 'INV-' . date('YmdHis'),
                'invoice_number' => $this->generateInvoice(),
                'sale_date' => now(),
                'customer_name' => $request->customer_name,
                'subtotal' => $request->sell_price,
                'grand_total' => $request->sell_price,
                'paid_amount' => $request->paid_amount,
                'change_amount' =>
                    $request->paid_amount - $request->sell_price,
                'payment_method' => 'cash',
                'status' => 'completed',
                'user_id' => auth()->id()
            ]);

            $unit = ProductUnit::findOrFail($request->product_unit_id);
            SalesDetail::create([
                'sale_id' => $sale->id,
                'product_id' => $unit->product_id,
                'product_unit_id' => $unit->id,
                'product_name' =>
                    $unit->product->brand . ' ' .
                    $unit->product->model,
                'imei1' => $unit->imei1,
                'buy_price' => $unit->buy_price,
                'sell_price' => $request->sell_price,
                'qty' => 1,
                'subtotal' => $request->sell_price
            ]);

            // update stok imei
            $unit->update([
                'status_stok' => 'sold'
            ]);

            DB::commit();
            return redirect()
                // ->route('sales.index')
                // ->with('success', 'Penjualan berhasil');
                 ->route('sales.print', $sale->id);

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
