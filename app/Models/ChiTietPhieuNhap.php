<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_phieu_nhap';

    protected $guarded = ['id'];

    public function getPhieuNhap()
    {
        return $this->belongsTo('App\Models\PhieuNhap', 'ma_phieu_nhap', 'ma_phieu_nhap');
    }
}
