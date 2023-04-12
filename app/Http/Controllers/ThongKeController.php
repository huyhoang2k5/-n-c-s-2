<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HangHoa;
use App\Models\ChiTietHangHoa;
use App\Models\ChiTietXuatKho;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ThongKeExport;


class ThongKeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $ma_ten = $request->input('ma_ten');
        $loai = $request->input('loai', 'id');
        $sap_xep = $request->input('sap_xep', 'asc');
        $page = request()->get('page', 1);

        $from_date != '' ? $from_date = Carbon::createFromFormat('m/d/Y', $from_date)->format('Y-m-d') : '';
        $to_date != '' ? $to_date = Carbon::createFromFormat('m/d/Y', $to_date)->format('Y-m-d') : '';


        $hang_hoa = HangHoa::when($ma_ten, function ($query, $ma_ten) {
            return $query->where('ten_hang_hoa', 'like', "%{$ma_ten}%")->orWhere('ma_hang_hoa', 'like', "%{$ma_ten}%");
        })
        ->has('getChiTiet')
        ->when($from_date, function ($query, $from_date) {
            return $query->whereDate('created_at', '>=', $from_date);
        })
        ->when($to_date, function ($query, $to_date) {
            return $query->whereDate('created_at', '<=', $to_date);
        })
        ->withSum(['getChiTiet' => function ($query) {
            $query->selectRaw('so_luong_goc');
        }], 'so_luong_goc')
        ->withSum(['getChiTiet' => function ($query) {
            $query->selectRaw('so_luong');
        }], 'so_luong')
        ->withSum(['getChiTietXuatKho' => function ($query) {
            $query->selectRaw('so_luong');
        }], 'so_luong')
        ->get();

        foreach ($hang_hoa as $hang) {
            $dt_nhap = $hang->getChiTiet->sum(function ($h) {
                    return ($h->so_luong_goc - $h->so_luong) * $h->gia_nhap;
            });

            $dt_xuat = $hang->getChiTietXuatKho->sum(function ($h) {
                    return $h->so_luong * $h->gia_xuat;
            });

            $gia_xuat = $hang->getChiTietXuatKho->sum(function ($h) {
                return $h->gia_xuat * $h->so_luong;
            });

            $gia_nhap = $hang->getChiTiet->sum(function ($h) {
                return $h->gia_nhap * $h->so_luong_goc;
            });

            $ten_loai_hang = $hang->getLoaiHang->ten_loai_hang;

            $hang['lai'] = $dt_xuat - $dt_nhap;
            $hang['ten_loai_hang'] = $ten_loai_hang;
            $hang->gia_xuat = $gia_xuat;
            $hang->gia_nhap = $gia_nhap;
        }


        if ($sap_xep == 'asc') {
            $hang_hoa = $hang_hoa->sortBy($loai);
        } else {
            $hang_hoa = $hang_hoa->sortByDesc($loai);
        }

        $data = $hang_hoa;
        $perPage = 20;

        $slicedData = $hang_hoa->slice(($page - 1) * $perPage, $perPage);
        $hang_hoa = new LengthAwarePaginator($slicedData, count($hang_hoa), $perPage);
        $hang_hoa->setPath(request()->url());

        $from_date != '' ? $from_date = Carbon::createFromFormat('Y-m-d', $from_date)->format('m/d/Y') : '';
        $to_date != '' ? $to_date = Carbon::createFromFormat('Y-m-d', $to_date)->format('m/d/Y')  : '';

        return view('thongke.index', compact('hang_hoa', 'loai', 'sap_xep', 'from_date', 'to_date', 'ma_ten', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function export(Request $request)
    {
        $data = collect(json_decode($request->input('data')));

        return Excel::download(new ThongKeExport($data->toArray()), 'thong-ke.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

}
