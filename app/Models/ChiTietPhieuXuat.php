<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuXuat extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_phieu_xuat';

    protected $guarded = ['id'];

    public function getPhieuXuat()
    {
        return $this->belongsTo(PhieuXuat::class, 'ma_phieu_xuat', 'ma_phieu_xuat');
    }

    public function getChiTiet()
    {
        return $this->belongsTo(ChiTietHangHoa::class, 'id_chi_tiet_hang_hoa', 'id');
    }

}
