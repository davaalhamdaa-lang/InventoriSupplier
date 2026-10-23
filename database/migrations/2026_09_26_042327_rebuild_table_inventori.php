<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // 1. Tabel User (Admin & Operator)
        Schema::create('tb_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('pin', 4)->unique();
            $table->string('password')->nullable(); // Nullable untuk operator
            $table->enum('role', ['ADMIN', 'OPERATOR']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Kategori
        Schema::create('tb_categories', function (Blueprint $table) {
            $table->id('category_id');
            $table->string('category_name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Tabel Master Barang
        Schema::create('tb_items', function (Blueprint $table) {
            $table->id('item_id');
            $table->unsignedBigInteger('category_id');
            $table->string('item_name', 200);
            $table->text('description')->nullable();
            $table->enum('jenis_satuan', ['WEIGHT', 'VOLUME', 'PACK', 'BOX', 'PCS']);
            $table->string('satuan_dasar', 50); // E.g., 'Gram', 'Mililiter', 'Pcs'
            $table->decimal('current_stock', 12, 2)->default(0.00);
            $table->decimal('min_stock_alert', 12, 2)->default(0.00);
            $table->timestamps();
            
            $table->foreign('category_id')->references('category_id')->on('tb_categories');
        });

        // 4. Tabel Transaksi Histori
        Schema::create('tb_transactions', function (Blueprint $table) {
            $table->id('trx_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['IN', 'OUT', 'REVISION']);
            $table->decimal('qty', 12, 2); 
            $table->string('satuan_transaksi', 20); // Satuan yang dipakai saat input (e.g., 'KG')
            $table->decimal('stock_sebelum', 12, 2);
            $table->decimal('stock_sesudah', 12, 2);
            $table->text('catatan')->nullable();
            $table->timestamp('date_recorded')->useCurrent();
            $table->timestamps();

            $table->foreign('item_id')->references('item_id')->on('tb_items');
            $table->foreign('user_id')->references('id')->on('tb_users');
        });

        // 5. Tabel Audit Log (Aktivitas Sistem)
        Schema::create('tb_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('action', 50); // LOGIN, CREATE, UPDATE, DELETE
            $table->string('table_name', 100)->nullable();
            $table->unsignedBigInteger('record_id')->nullable();
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down() {
        Schema::dropIfExists('tb_audit_logs');
        Schema::dropIfExists('tb_transactions');
        Schema::dropIfExists('tb_items');
        Schema::dropIfExists('tb_categories');
        Schema::dropIfExists('tb_users');
    }
};