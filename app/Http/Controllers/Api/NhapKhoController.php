<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhapKho;
use App\Models\ChiTietHangHoa;
use App\Models\HangHoa;
use Illuminate\Support\Facades\Validator;

class NhapKhoController extends Controller
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
        $validator = Validator::make($data[0], [
            'ma_phieu_nhap' => 'required|max:20|unique:phieu_nhap,ma_phieu_nhap',
            'ngay_nhap' => 'required',
            'id_user' => 'required|integer',
            'ma_ncc' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message'=> 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Vui lòng tải lại trang!']);
        } else {

            $phieu_nhap = NhapKho::create([
                'ma_phieu_nhap' => $data[0]['ma_phieu_nhap'],
                'ngay_nhap' => $data[0]['ngay_nhap'],
                'id_user' => $data[0]['id_user'],
                'ma_ncc' => $data[0]['ma_ncc'],
                'mo_ta' => strlen($data[0]['mo_ta']) == 0 ? 'Không có mô tả cụ thể!' : $data[0]['mo_ta']
            ]);

            if (count($data) > 1) {;
                for ($i = 1; $i < count($data); $i++) {
                    ChiTietHangHoa::create([
                        'ma_phieu_nhap' => $data[0]['ma_phieu_nhap'],
                        'ma_ncc' => $data[0]['ma_ncc'],
                        'ma_hang_hoa' => $data[$i]['ma_hang_hoa'],
                        'so_luong' => $data[$i]['so_luong'],
                        'so_luong_goc' => $data[$i]['so_luong'],
                        'trang_thai' => 3,
                        'gia_nhap' => $data[$i]['gia_nhap'],
                        'ngay_san_xuat' => $data[$i]['ngay_san_xuat'],
                        'tg_bao_quan' => $data[$i]['tg_bao_quan'],
                    ]);
                }

                return response()->json(['message'=> 'Nhập kho thành công', 'type' => 'success', 'redirect' => route('nhap-kho.index')], 200);
            } else {
                NhapKho::delete($phieu_nhap->id);
                ChiTietHangHoa::where('ma_phieu_nhap', $phieu_nhap->ma_phieu_nhap)->delete();
                return response()->json(['message'=> 'Có lỗi xảy ra trong quá trình nhập dữ liệu. Vui lòng kiểm tra và thử lại!']);
            }

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
