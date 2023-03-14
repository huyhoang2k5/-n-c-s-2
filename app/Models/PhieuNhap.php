<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'phieu_nhap';

    protected $guarded = ['id'];

    public function getChiTietHangHoa()
    {
        return $this->hasOne(ChiTietHangHoa::class, 'ma_phieu_nhap', 'ma_phieu_nhap');
    }

    public function getUsers()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
