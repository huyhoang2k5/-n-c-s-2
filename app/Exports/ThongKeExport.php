<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;

class ThongKeExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $result = [];
        foreach ($this->data as $key => $row) {
            $result[] = [
                $key+1,
                $row->ma_hang_hoa,
                $row->ten_hang_hoa,
                $row->get_chi_tiet_sum_so_luong,
                $row->get_chi_tiet_sum_gia_nhap,
                $row->get_chi_tiet_phieu_xuat_sum_so_luong,
                $row->get_chi_tiet_phieu_xuat_sum_gia_xuat,
                $row->lai,
            ];
        }
        return $result;
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã hàng hóa',
            'Tên hàng hóa',
            'Nhập',
            'Tổng giá trị',
            'Xuất',
            'Doanh thu',
            'Lãi'
        ];
    }
}

