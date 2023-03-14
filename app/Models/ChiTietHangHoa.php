<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHangHoa extends Model
{
    use HasFactory;

    protected $table = "chi_tiet_hang_hoa";

    protected $guarded = ['id'];


    public function getHangHoa()
    {
        return $this->belongsTo(HangHoa::class, 'ma_hang_hoa', 'ma_hang_hoa');
    }

    public function getPhieuNhap()
    {
        return $this->belongsTo(PhieuNhap::class, 'ma_phieu_nhap', 'ma_phieu_nhap');
    }
}
