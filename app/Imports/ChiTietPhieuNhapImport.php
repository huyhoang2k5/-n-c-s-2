<?php

namespace App\Imports;

use App\Models\ChiTietPhieuNhap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChiTietPhieuNhapImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $ma_phieu_nhap;

    public function setMaPhieu($ma_phieu_nhap)
    {
        $this->ma_phieu_nhap = $ma_phieu_nhap;
    }

    public function headingRow() : int
    {
        return 1;
    }

    public function model(array $row)
    {
        $row['ma_phieu_nhap'] = $this->ma_phieu_nhap;

        return new ChiTietPhieuNhap([
            'ma_phieu_nhap' => $row['ma_phieu_nhap'],
            'ma_hang_hoa' => $row['ma_hang_hoa'],
            'ma_ncc' => $row['ma_nha_cung_cap'],
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

    public function rules(): array
    {
        return [
            '*.ma_phieu_nhap' => 'required|string|max:30',
            '*.ma_hang_hoa' => 'required|string|max:30',
            '*.ma_ncc' => 'required|string|max:30',
            '*.so_luong' => 'required|integer|min:0',
            '*.gia_nhap' => 'required|integer|min:0',
            '*.ngay_san_xuat' => 'date_format:Y/m/d',
            '*.tg_bao_quan' => 'required|integer|min:0',
        ];
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
