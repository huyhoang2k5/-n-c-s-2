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
        Schema::create('phieu_xuat', function (Blueprint $table) {
            $table->id();
            $table->string('khach_hang');
            $table->string('dia_chi');
            $table->date('ngay_xuat')->nullable()->default(now()->toDateString());
            $table->string('chi_tiet')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_xuat');
    }
};
