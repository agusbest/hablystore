<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/', function () {
//     return view('dashboard');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::resource('products', ProductController::class);
// DETAIL / LIST UNIT
Route::get(
    '/products/{product}/units',
    [ProductController::class, 'units']
)->name('products.units');

Route::prefix('sales')->group(function () {

Route::get('/', [SaleController::class, 'index'])
        ->name('sales.index');

Route::get('/create', [SaleController::class, 'create'])
        ->name('sales.create');

Route::post('/store', [SaleController::class, 'store'])
        ->name('sales.store');

});


Route::get('/find-unit', [SaleController::class, 'findUnit'])
    ->name('sales.findUnit');

Route::get('/{id}/print', [SaleController::class, 'print'])
    ->name('sales.print');    

require __DIR__.'/auth.php';
