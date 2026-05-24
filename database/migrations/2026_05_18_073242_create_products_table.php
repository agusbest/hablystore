<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('merk');
            $table->string('tipe');
            $table->string('ram')->nullable();
            $table->string('rom')->nullable();
            $table->string('warna')->nullable();
            $table->enum('kategori', [
                'Baru',
                'Second',
                'Batangan',
                'Lengkap'
            ]);
            $table->decimal('harga', 18,2)->default(0);
            $table->integer('stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
