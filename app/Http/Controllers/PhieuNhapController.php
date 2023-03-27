<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\ChiTietHangHoaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Carbon\Carbon;


class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nha_cung_cap = NhaCungCap::get();
        $ma_phieu_nhap = PhieuNhap::latest()->first()->ma_phieu_nhap ?? "PN000000";

        $lastNumber = (int) substr($ma_phieu_nhap, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        $phieu_nhap = [];

        PhieuNhap::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_nhap) {
            foreach ($chunk as $phieu) {
                $phieu_nhap[] = $phieu;
            }
        });

        return view('nhapkho.index', compact('phieu_nhap', 'ma_phieu_nhap', 'nha_cung_cap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hang_hoa = HangHoa::get();
        $nha_cung_cap = NhaCungCap::get();
        $ma_phieu_nhap = PhieuNhap::latest()->first()->ma_phieu_nhap ?? "PN000000";

        $lastNumber = (int) substr($ma_phieu_nhap, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);


        return view('nhapkho.create', compact('ma_phieu_nhap', 'hang_hoa', 'nha_cung_cap'));
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $phieu_nhap = PhieuNhap::where('ma_phieu_nhap', $code)->firstOrFail();

        $chi_tiet_phieu_nhap = [];

        ChiTietHangHoa::where('ma_phieu_nhap', $code)->orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$chi_tiet_phieu_nhap) {
            foreach ($chunk as $chi_tiet) {
                $chi_tiet_phieu_nhap[] = $chi_tiet;
            }
        });

        return view('nhapkho.show', compact('phieu_nhap', 'chi_tiet_phieu_nhap'));
    }


    public function import(ExcelRequest $request)
    {
        $data = $request->all();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;
        $dt = Carbon::now('Asia/Ho_Chi_Minh');

        $phieu_nhap = PhieuNhap::firstOrCreate([
            'ma_phieu_nhap' => $data['ma_phieu_nhap'],
        ], [
            'ma_phieu_nhap' => $data['ma_phieu_nhap'],
            'ngay_nhap' => $data['ngay_nhap'] ?? $dt->toDateString(),
            'ma_ncc' => $data['ma_ncc'],
            'id_user' => auth()->user()->id,
            'mo_ta' => $mo_ta ?? 'Không có mô tả cụ thể!'
        ]);

        try {
            $file = $request->file('excel_file');
            $ma_phieu_nhap = $data['ma_phieu_nhap'];
            $ma_ncc = $data['ma_ncc'];

            $ct_hang_hoa = new ChiTietHangHoaImport();
            $ct_hang_hoa->setMaPhieu($ma_phieu_nhap);
            $ct_hang_hoa->setTrangThai(3);
            $ct_hang_hoa->setNhaCungCap($ma_ncc);

            Excel::import($ct_hang_hoa, $file);
            return redirect()->route('nhap-kho.index')->with(['status' => 'Thêm dữ liệu từ file Excel thành công!!!', 'type' => 'success']);

        } catch(ValidationException $e) {
            PhieuNhap::delete($phieu_nhap->id);
            $ct_hang_hoa->truncate();

            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Dòng " . $failure->row() . ": " . $failure->errors()[0];
            }

            return back()->with(['errors' => $errors, 'status' => 'Xuất hiện lỗi trong khi thêm dữ liệu từ file Excel!', 'type' => 'danger']);
        }
    }
}
