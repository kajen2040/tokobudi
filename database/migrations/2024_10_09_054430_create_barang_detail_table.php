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
        Schema::create('barang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->references('id')->on('barang')->constrained('barang', 'id');
            $table->foreignId('jenis_id')->references('id')->on('jenis')->constrained('jenis', 'id');
            $table->foreignId('satuan_id')->references('id')->on('satuan')->constrained('satuan', 'id');

            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->string('barcode')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harga');
    }
};
