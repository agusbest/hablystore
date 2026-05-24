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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
              // nomor invoice
            $table->string('invoice_number')->unique();
            // tanggal transaksi
            $table->date('sale_date');
            // customer
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            // total transaksi
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('discount')->default(0);
            $table->bigInteger('grand_total')->default(0);
            // pembayaran
            $table->bigInteger('paid_amount')->default(0);
            $table->bigInteger('change_amount')->default(0);

            // metode pembayaran
            $table->enum('payment_method', [
                'cash',
                'transfer',
            ])->default('cash');

            // status transaksi
            $table->enum('status', [
                'draft',
                'completed',
                'cancelled'
            ])->default('completed');

            // catatan
            $table->text('notes')->nullable();

            // user kasir
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
