<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapKho extends Model
{
    use HasFactory;

    protected $table = 'phieu_nhap';

    protected $guarded = ['id'];

    public function getUsers()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getNhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'ma_ncc', 'ma_ncc');
    }
}
