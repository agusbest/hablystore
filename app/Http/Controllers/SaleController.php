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
    public function index(Request $request)
    {
        $search = $request->search;
        $sales = Sale::with([
            'details.product'
        ])
            ->when($search, function ($q) use ($search) {

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


    public function create()
    {
        $products = Product::with('units')->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $cart = session('sales_cart', []);
            $grandTotal = collect($cart)->sum(function ($item) {
                return (float) $item['sell_price'];
            });

            $sale = Sale::create([
                'invoice_number' => $this->generateInvoice(),
                'sale_date' => now(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'subtotal' => $grandTotal,
                'grand_total' => $grandTotal,
                'paid_amount' => $request->paid_amount,
                'change_amount' =>
                $request->paid_amount - $grandTotal,
                'payment_method' => 'cash',
                'status' => 'completed',
                'user_id' => auth()->id()

            ]);
            // LOOP CART
            foreach (session('sales_cart', []) as $item) {
                $unit = ProductUnit::findOrFail(
                    $item['product_unit_id']
                );
                SalesDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $unit->product_id,
                    'product_unit_id' => $unit->id,
                    'product_name' =>
                    $unit->product->brand . ' ' .
                        $unit->product->model . ' ' .
                        $unit->product->ram . ' ' .
                        $unit->product->rom . ' ' .
                        $unit->product->color . ' ' .
                        $unit->category_type,
                    'imei1' => $unit->imei1,
                    'buy_price' => $unit->buy_price,
                    'sell_price' => $item['sell_price'],
                    'qty' => 1,
                    'subtotal' => $item['sell_price']
                ]);

                // UPDATE STATUS SOLD
                $unit->update([
                    'status_stok' => 'sold'
                ]);
            }
            DB::commit();
            session()->forget('sales_cart');

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
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

        return 'FP-' . $date . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function addCart(Request $request)
    {
        $unit = ProductUnit::with('product')
            ->where('imei1', $request->imei)
            ->where('status_stok', 'ready')
            ->first();

        if (!$unit) {

            return response()->json([
                'success' => false
            ]);
        }

        $cart = session()->get('sales_cart', []);

        // Cegah double IMEI
        foreach ($cart as $item) {

            if ($item['imei1'] == $unit->imei1) {

                return response()->json([
                    'success' => false,
                    'message' => 'IMEI sudah ada di cart'
                ]);
            }
        }

        $cart[] = [

            'product_unit_id' => $unit->id,
            'product_id'      => $unit->product_id,
            'imei1'           => $unit->imei1,
            'product_name'    => $unit->product->brand . ' ' .
                $unit->product->model,

            'ram'             => $unit->product->ram,
            'rom'             => $unit->product->rom,
            'color'           => $unit->product->color,
            'category_type'   => $unit->product->category_type,
            'sell_price'      => $unit->sell_price,
            'discount'        => 0

        ];

        session([
            'sales_cart' => $cart
        ]);

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }

    public function removeCart(Request $request)
    {
        $cart = session()->get('sales_cart', []);

        foreach ($cart as $key => $item) {

            if ($item['imei1'] == $request->imei) {

                unset($cart[$key]);

                // rapikan index array
                $cart = array_values($cart);

                session([
                    'sales_cart' => $cart
                ]);

                return response()->json([
                    'success' => true,
                    'cart' => $cart
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ]);
    }

    public function clearCart()
    {
        session()->forget('sales_cart');

        return response()->json([
            'success' => true
        ]);
    }

    public function updatePrice(Request $request)
    {
        $cart = session()->get('sales_cart', []);

        foreach ($cart as $key => $item) {

            if ($item['imei1'] == $request->imei) {

                $cart[$key]['sell_price'] = $request->sell_price;
            }
        }

        session([
            'sales_cart' => $cart
        ]);

        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
}
