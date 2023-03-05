<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'phieu_nhap';

    protected $guarded = ['id'];

    public function getChiTietPhieuNhap()
    {
        return $this->hasOne('App\Models\ChiTietPhieuNhap', 'ma_phieu_nhap', 'ma_phieu_nhap');
    }
}
