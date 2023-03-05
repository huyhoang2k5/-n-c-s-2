<?php

namespace App\Imports;

use App\Models\ChiTietHangHoa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ChiTietHangHoaImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ChiTietHangHoa([
            'ma_ncc' => $row['ma_nha_cung_cap'],
            'ma_hang_hoa' => $row['ma_hang_hoa'],
            'so_luong' => $row['so_luong'],
            'gia_nhap' => $row['gia_nhap'],
            'ngay_san_xuat' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngay_san_xuat'])->format('Y-m-d'),
            'tg_bao_quan' => $row['thoi_gian_bao_quan']
        ]);
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
