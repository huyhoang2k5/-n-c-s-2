<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\ChiTietPhieuNhapImport;
use App\Imports\ChiTietHangHoaImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nhapkho.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NhapKho $nhapKho)
    {
        //
    }

    public function import(ExcelRequest $request)
    {
        $data = $request->all();

        // $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        // $phieu_nhap = PhieuNhap::firstOrCreate([
        //     'ma_phieu_nhap' => $data['ma_phieu_nhap'],
        // ], [
        //     'ma_phieu_nhap' => $data['ma_phieu_nhap'],
        //     'ngay_nhap' => $data['ngay_nhap'],
        //     'id_user' => Auth::user()->id,
        //     // 'mo_ta' => $mo_ta
        // ]);

        try {
            $file = $request->file('excel_file');
            $import = new ChiTietPhieuNhapImport();
            $import->setMaPhieu($request->input('ma_phieu_nhap'));

            Excel::import($import, $file);
            Excel::import(new ChiTietHangHoaImport, $file);
            return redirect()->route('nhap-kho.index')->with('success', 'Thêm dữ liệu từ file Excel thành công!!!');

        } catch(ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Dòng " . $failure->row() . ": " . $failure->errors()[0];
            }
            
            return redirect()->back()->with(['errors' => $errors]);
        }
    }
}
