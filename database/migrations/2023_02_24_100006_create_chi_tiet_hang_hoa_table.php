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
        Schema::create('chi_tiet_hang_hoa', function (Blueprint $table) {
            $table->id();
            $table->char('ma_phieu_nhap')->references('ma_phieu_nhap')->on('phieu_nhap')->nullOnDelete();
            $table->char('ma_hang_hoa')->references('ma_hang_hoa')->on('hang_hoa')->cascadeOnDelete();
            $table->char('ma_ncc')->references('ma_ncc')->on('nha_cung_cap')->nullOnDelete();
            $table->integer('so_luong')->unsigned();
            $table->integer('so_luong_goc')->unsigned();
            $table->foreignId('id_trang_thai')->constrained('trang_thai')->cascadeOnDelete();
            $table->integer('gia_nhap')->unsigned();
            $table->date('ngay_san_xuat')->default(now()->toDateString());
            $table->integer('tg_bao_quan')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_hang_hoa');
    }
};
