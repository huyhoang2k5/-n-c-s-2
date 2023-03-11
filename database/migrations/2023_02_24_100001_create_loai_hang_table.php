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
        Schema::create('loai_hang', function (Blueprint $table) {
            $table->id();
            $table->string('ten_loai_hang');
            $table->integer('trang_thai')->default(2);
            $table->string('mo_ta')->nullable()->default('Mặt hàng này chưa có mô tả cụ thể.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_hang');
    }
};
