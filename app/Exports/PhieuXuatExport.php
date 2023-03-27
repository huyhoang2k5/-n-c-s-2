<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\ExportFailed;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use App\Models\ChiTietPhieuXuat;

class PhieuXuatExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã hàng hóa',
            'Tên hàng hóa',
            'Đơn vị tính',
            'Số lượng',
            'Đơn giá',
            'Thành tiền'
        ];
    }
}
