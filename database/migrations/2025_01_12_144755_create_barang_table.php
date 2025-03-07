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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('id_barang')->primary()->unique();
            $table->string('barcode')->unique()->nullable();
            $table->string('nama_barang');
            $table->string('jb_id');
            $table->string('merk');
            $table->integer('stok');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->text('keterangan')->nullable();
            $table->foreign('jb_id')->references('id_jb')->on('jenis_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};