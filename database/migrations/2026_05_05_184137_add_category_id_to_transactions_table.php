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
        Schema::table('transactions', function (Blueprint $table) {
            // Menambahkan kolom category_id yang berelasi dengan tabel categories
            // Kita pakai nullable() berjaga-jaga jika kamu sudah punya data lama di tabel transaksi agar tidak error
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menghapus relasi dan kolom jika di-rollback
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
