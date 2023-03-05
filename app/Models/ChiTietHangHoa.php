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
        return $this->belongsTo('App\Models\HangHoa', 'ma_hang_hoa', 'ma_hang_hoa');
    }

    public function getChiTietPhieuNhap()
    {
        return $this->belongsTo('App\Models\ChiTietPhieuNhap', 'ma_hang_hoa', 'ma_hang_hoa');
    }
}
