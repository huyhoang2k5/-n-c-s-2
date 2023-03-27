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
        return $this->hasMany(HangHoa::class, 'id_loai_hang');
    }

    public function getTrangThai()
    {
        return $this->beLongsTo(TrangThai::class, 'id_trang_thai');
    }

}
