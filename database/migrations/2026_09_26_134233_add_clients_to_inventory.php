<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Membuat tabel Klien (SPPG)
        Schema::create('tb_clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('nama_sppg', 150);
            $table->text('alamat_sppg');
            $table->timestamps();
        });

        // 2. Menambahkan kolom client_id ke tabel transaksi yang sudah ada
        Schema::table('tb_transactions', function (Blueprint $table) {
            // Ditambahkan sebagai nullable karena Transaksi IN (Masuk) tidak butuh klien
            $table->unsignedBigInteger('client_id')->nullable()->after('item_id');
            
            // Menjadikannya Foreign Key (Relasi)
            $table->foreign('client_id')->references('client_id')->on('tb_clients')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('tb_transactions', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });

        Schema::dropIfExists('tb_clients');
    }
};