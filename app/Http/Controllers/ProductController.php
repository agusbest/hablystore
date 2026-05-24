<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// Halaman Pertama Tampil

public function index(Request $request)
{
   $search = $request->search;
  $products = Product::select(
        'id',
        'brand',
        'model',
        'ram',
        'rom',
        'color'
    )
    ->withCount([
        'units as stok' => function ($q) {
            $q->where('status_stok', 'ready');
        }
    ])
    ->when($search, function ($q) use ($search) {
        $q->where('brand', 'like', "%{$search}%")
          ->orWhere('model', 'like', "%{$search}%")
          ->orWhere('color', 'like', "%{$search}%");
    })
    ->latest()
    ->paginate(20);

    return view(
        'products.barang',
        compact('products')
    );
}

     // =====================================
    // LIST DETAIL PRODUCT UNIT / IMEI
    // =====================================

    public function units(Product $product)
    {
         $units = $product->units()
        ->where('status_stok', 'ready')
        ->latest()
        ->get();

          return response()->json($units);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   
//    Simpan Data Barang
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()
            ->route('products.index')
            ->with('success', 'Barang berhasil ditambahkan');
  
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view(
        'products.edit',
        compact('product')
       );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
        ]);

        $product->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'ram'   => $request->ram,
            'rom'   => $request->rom,
            'color' => $request->color,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Data berhasil diupdate');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // hapus semua unit
        $product->units()->delete();

        // hapus product
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
