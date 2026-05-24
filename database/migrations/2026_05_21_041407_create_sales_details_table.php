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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('sale_id');

    $table->unsignedBigInteger('product_id');

    $table->unsignedBigInteger('product_unit_id');

    $table->string('product_name');

    $table->string('imei1')->nullable();

    $table->bigInteger('buy_price')->default(0);

    $table->bigInteger('sell_price')->default(0);

    $table->integer('qty')->default(1);

    $table->bigInteger('subtotal')->default(0);

    $table->timestamps();

    // foreign key
    $table->foreign('sale_id')
        ->references('id')
        ->on('sales')
        ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
