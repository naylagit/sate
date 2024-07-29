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
        Schema::create('pengelolaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bahan_id')->constrained('bahan_bakus')->onDelete('cascade');
            $table->string('kategori');
            $table->integer('jumlah');
            $table->string('supplier')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengelolaans');
    }
};
