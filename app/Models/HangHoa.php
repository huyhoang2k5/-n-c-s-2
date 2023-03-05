<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangHoa extends Model
{
    use HasFactory;

    protected $table = 'hang_hoa';

    protected $guarded = ['id'];

    protected $fillable = [

    ];

    protected $hidden = [

    ];

    protected $casts = [

    ];

    public function getLoaiHang()
    {
        return $this->belongsTo('App\Models\LoaiHang', 'id_loai_hang');
    }

    public function getChiTiet()
    {
        return $this->hasMany('App\Models\ChiTietHangHoa', 'ma_hang_hoa', 'ma_hang_hoa');
    }
}
