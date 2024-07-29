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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('id_transaksi');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('meja_id')->constrained('mejas')->onDelete('cascade');
            $table->enum('jenis', [1, 2]);
            $table->decimal('total', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->decimal('dibayarkan', 15, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->enum('status', [1, 2, 3]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
