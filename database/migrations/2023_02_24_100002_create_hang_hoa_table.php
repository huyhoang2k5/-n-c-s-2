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
        Schema::create('hang_hoa', function (Blueprint $table) {
            $table->id();
            $table->string('ma_hang_hoa');
            $table->string('ten_hang_hoa');
            $table->string('mo_ta')->nullable()->default('Mặt hàng này chưa có mô tả cụ thể.');
            $table->foreignId('id_loai_hang')->constrained('loai_hang')->cascadeOnDelete();
            $table->string('don_vi_tinh');
            $table->string('barcode')->nullable();
            $table->string('img')->nullable()->default('hang_hoa.jpg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hang_hoa');
    }
};
