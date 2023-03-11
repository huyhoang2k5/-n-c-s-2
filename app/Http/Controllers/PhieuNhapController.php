<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
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
        //Lay ma phieu nhap Excel
        $ma_phieu_nhap = PhieuNhap::latest()->first()->ma_phieu_nhap;

        if (!$ma_phieu_nhap) {
            $ma_phieu_nhap = "PN000000";
        } else {
            $lastNumber = (int) substr($ma_phieu_nhap, 2);
            $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
            $nextNumber = $lastNumber + 1;
            $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);
        }

        //Danh sach phieu nhap
        $phieu_nhap = [];

        PhieuNhap::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_nhap) {
            foreach ($chunk as $phieu) {
                $phieu_nhap[] = $phieu;
            }
        });

        return view('nhapkho.index', compact('phieu_nhap', 'ma_phieu_nhap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ma_phieu_nhap = PhieuNhap::latest()->first()->ma_phieu_nhap;

        if (!$ma_phieu_nhap) {
            $ma_phieu_nhap = "PN000000";
        } else {
            $lastNumber = (int) substr($ma_phieu_nhap, 2);
            $lastNumberLength = strlen((string)substr($ma_phieu_nhap, 2));
            // dd($lastNumberLength);
            $nextNumber = $lastNumber + 1;
            $ma_phieu_nhap = 'PN' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);
        }

        $hang_hoa = HangHoa::get();

        return view('nhapkho.create', compact('ma_phieu_nhap', 'hang_hoa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
        $data = json_decode($request->getContent(), true);

        return redirect()->route('nhap-kho.index');
    }
    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $phieu_nhap = PhieuNhap::where('ma_phieu_nhap', $code)->firstOrFail();
        $chi_tiet_phieu_nhap = ChiTietHangHoa::where('ma_phieu_nhap', $code)->get()->sortByDesc('id')->all();

        return view('nhapkho.show', compact('phieu_nhap', 'chi_tiet_phieu_nhap'));
    }

    public function showItem($code, $id)
    {

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
            'id_user' => auth()->user()->id,
            'mo_ta' => $mo_ta ?? 'Không có mô tả cụ thể!'
        ]);

        try {
            $file = $request->file('excel_file');
            $ma_phieu_nhap = $data['ma_phieu_nhap'];

            $ct_hang_hoa = new ChiTietHangHoaImport();
            $ct_hang_hoa->setMaPhieu($ma_phieu_nhap);

            Excel::import($ct_hang_hoa, $file);
            return redirect()->route('nhap-kho.index')->with('status-success', 'Thêm dữ liệu từ file Excel thành công!!!');

        } catch(ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Dòng " . $failure->row() . ": " . $failure->errors()[0];
            }

            return redirect()->back()->with(['errors' => $errors, 'status-error' => 'Xuất hiện lỗi trong khi thêm dữ liệu từ file Excel!']);
        }
    }
}
