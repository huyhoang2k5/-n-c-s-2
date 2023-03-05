<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiHang extends Model
{
    use HasFactory;

    protected $table = 'loai_hang';

    protected $guarded = ['id'];

    public function getHangHoa()
    {
        return $this->hasMany('App\Models\HangHoa', 'id_loai_hang');
    }

    public function getTrangThai()
    {
        return $this->hasOne('App\Models\TrangThai', 'id', 'trang_thai');
    }

}
