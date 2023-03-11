<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhieuNhap;
use App\Models\ChiTietHangHoa;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $mo_ta = json_decode($data[0]['mo_ta'], true)->ops[0]->insert ?? 'Loại hàng này chưa có mô tả cụ thể!';

        try {
            $phieu_nhap = PhieuNhap::updateOrCreate([
                'ma_phieu_nhap' => $data[0]['ma_phieu_nhap'],
                'ngay_nhap' => $data[0]['ngay_nhap']
            ],
            [
                'ma_phieu_nhap' => $data[0]['ma_phieu_nhap'],
                'ngay_nhap' => $data[0]['ngay_nhap'],
                'id_user' => $data[0]['id_user'],
                'mo_ta' => $mo_ta
            ]);

            for ($i = 1; $i < count($data); $i++) {

                ChiTietHangHoa::create([
                    'ma_phieu_nhap' => $data[0]['ma_phieu_nhap'],
                    'ma_hang_hoa' => $data[$i]['ma_hang_hoa'],
                    'ma_ncc' => $data[$i]['ma_ncc'],
                    'so_luong' => $data[$i]['so_luong'],
                    'so_luong_goc' => $data[$i]['so_luong'],
                    'trang_thai' => 3,
                    'gia_nhap' => $data[$i]['gia_nhap'],
                    'ngay_san_xuat' => $data[$i]['ngay_san_xuat'],
                    'tg_bao_quan' => $data[$i]['tg_bao_quan'],
                ]);
            }
            
            return response()->json(['status'=> 'Nhập kho thành công', 'type' => 'success', 'redirect' => route('nhap-kho.index')], 200);
        } catch (\Throwable $th) {

            return response()->json(['status'=> 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Vui lòng kiểm tra dữ liệu và thử lại!', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
