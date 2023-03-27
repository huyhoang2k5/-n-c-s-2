<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use App\Models\ChiTietHangHoa;
use App\Models\TrangThai;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Quản lý nhà cung cấp";
        $nha_cung_cap = NhaCungCap::get();

        return view('nhacungcap.index', compact('nha_cung_cap', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Thêm mới nhà cung cấp";
        $trang_thai = TrangThai::get();
        $nha_cung_cap = NhaCungCap::get();

        return view('nhacungcap.create', compact('trang_thai', 'title', 'nha_cung_cap'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $nha_cung_cap = NhaCungCap::firstOrCreate([
            'ma_ncc' => $data['ma_ncc']
        ],
        [
            'ma_ncc' => $data['ma_ncc'],
            'ten_ncc' => $data['ten_ncc'],
            'dia_chi' => $data['dia_chi'],
            'sdt' => $data['sdt'],
            'id_trang_thai' => $data['id_trang_thai'] ?? 3,
            'mo_ta' => $mo_ta
        ]);

        if ($nha_cung_cap->wasRecentlyCreated) {
            return redirect()->route('nha-cung-cap.index')->with(['status' => 'Thêm mới nhà cung cấp thành công!', 'type' => 'success']);
        } else {
            return redirect()->back()->with(['status' => 'Thêm mới thất bại do đã tồn tại nhà cung cấp từ trước hoặc do lỗi!', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();
        $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_ncc', $code)->get()->sortByDesc('id')->all();
        $title = "Xem thông tin " . $nha_cung_cap->ten_ncc;

        if ($nha_cung_cap) {
            return view('nhacungcap.show', compact('nha_cung_cap', 'title', 'chi_tiet_hang_hoa'));
        } else {
            return back()->with(['status' => 'Không tìm thấy nhà cung cấp, xin vui lòng thử lại sau!', 'type' => 'danger']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();
        $title = "Sửa thông tin " . $nha_cung_cap->ten_ncc;
        $trang_thai = TrangThai::get();

        if ($nha_cung_cap) {
            return view('nhacungcap.edit', compact('nha_cung_cap', 'trang_thai', 'title'));
        } else {
            return back()->with(['status' => 'Không tìm thấy nhà cung cấp, xin vui lòng thử lại sau!', 'type' => 'danger']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $request->validate([
            'sdt' => 'required|regex:/(0)[0-9]{9}/'
        ], [
            'sdt.required' => 'Bạn cần thêm số điện thoại!',
            'sdt.regex' => 'Định dạng số điện thoại không đúng.'
        ]);

        $data = $request->all();

        $nha_cung_cap = NhaCungCap::where('ma_ncc', $code)->first();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Nhà cung cấp này chưa có mô tả cụ thể!';

        $status = $nha_cung_cap->update([
            'ma_ncc' => $data['ma_ncc'],
            'ten_ncc' => $data['ten_ncc'],
            'dia_chi' => $data['dia_chi'],
            'sdt' => $data['sdt'],
            'id_trang_thai' => $data['id_trang_thai'],
            'mo_ta' => $file_name,
            'mo_ta' => $mo_ta
        ]);

        if ($status) {
            return redirect()->route('nha-cung-cap.index')->with(['status' => 'Sửa thông tin nhà cung cấp thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = NhaCungCap::destroy($id);

        if ($status) {
            return redirect()->route('nha-cung-cap.index')->with(['status' => 'Xóa nhà cung cấp thành công', 'type' => 'success']);
        } else{
            return back()->with(['status' => 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }
}
