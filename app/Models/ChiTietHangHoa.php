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

    public function getNhapKho()
    {
        return $this->belongsTo(NhapKho::class, 'ma_phieu_nhap', 'ma_phieu_nhap');
    }

    public function getNhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'ma_ncc', 'ma_ncc');
    }

    public function getChiTietXuatKho()
    {
        return $this->hasMany(ChiTietXuatKho::class, 'id_chi_tiet_hang_hoa', 'id');
    }
}
