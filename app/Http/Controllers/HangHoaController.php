<?php

namespace App\Http\Controllers;

use App\Models\HangHoa;
use App\Models\LoaiHang;
use App\Models\ChiTietHangHoa;
use Illuminate\Http\Request;
use App\Http\Requests\HangHoaStoreRequest;
use App\Http\Requests\HangHoaUpdateRequest;
use Storage;

class HangHoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hang_hoa = [];
        $title = "Quản lý hàng hóa";

        HangHoa::orderBy('id')->chunkById(100, function ($chunk) use (&$hang_hoa) {
            foreach ($chunk as $hang) {
                if ($hang->getLoaiHang->trang_thai != 1) {
                    $hang_hoa[] = $hang;
                }
            }
        });

        return view('hanghoa.index', compact('hang_hoa', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loai_hang = LoaiHang::where('id_trang_thai', 3)->get();
        $title = "Thêm mới hàng hóa";

        return view('hanghoa.create', compact('loai_hang', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HangHoaStoreRequest $request)
    {
        $data = $request->validated();
        $file_name = "hanghoa.jpg";

        if ($request->hasFile('change_img')) {
            $img = $request->file('change_img');
            $file_name = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/hanghoa', $file_name);
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Hàng hóa này chưa có mô tả cụ thể!';

        $hang_hoa = HangHoa::firstOrCreate([
            'ma_hang_hoa' => $data['ma_hang_hoa']
        ],
        [
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['id_loai_hang'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'barcode' => $data['barcode'] ?? '',
            'img' => $file_name,
            'mo_ta' => $mo_ta
        ]);

        if ($hang_hoa->wasRecentlyCreated) {
            return redirect()->route('hang-hoa.index')->with(['status' => 'Thêm mới hàng hóa thành công!', 'type' => 'success']);
        } else {
            if ($request->hasFile('change_img')) {
                unlink(storage_path('app/public/images/hanghoa/' . $file_name));
            }
            return back()->with(['status' => 'Thêm mới thất bại do đã tồn tại hàng hóa từ trước hoặc do lỗi!', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $title = $hang_hoa->ten_hang_hoa;

        if ($hang_hoa) {
            $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', $code)->where('trang_thai', 3)->get()->sortByDesc('id')->all();
            return view('hanghoa.show', compact('hang_hoa', 'chi_tiet_hang_hoa', 'title'));
        } else {
            return back()->with(['status' => 'Không tìm thấy hàng hóa, xin vui lòng thử lại sau!', 'type' => 'danger']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $loai_hang = LoaiHang::where('id_trang_thai', 3)->get();
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $title = "Sửa thông tin " . $hang_hoa->ten_hang_hoa;

        if ($hang_hoa) {
            return view('hanghoa.edit', compact('hang_hoa', 'loai_hang', 'title'));
        } else {
            return back()->with(['status' => 'Không tìm thấy hàng hóa, xin vui lòng thử lại sau!', 'type' => 'danger']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HangHoaUpdateRequest $request, $code)
    {
        $data = $request->validated();

        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $file_name = $hang_hoa->img;

        if ($request->hasFile('change_img') && $file_name != $request->change_img) {
            $img = $request->file('change_img');
            $hang_hoa->img = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/hanghoa', $hang_hoa->img);
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Hàng hóa này chưa có mô tả cụ thể!';

        $status = $hang_hoa->update([
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['id_loai_hang'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'barcode' => $data['barcode'],
            'img' => $hang_hoa->img,
            'mo_ta' => $mo_ta
        ]);

        if ($status) {
            if ($request->hasFile('change_img') && $file_name != $request->change_img && $file_name != 'hanghoa.jpg') {
                unlink(storage_path('app/public/images/hanghoa'.$file_name));
            };
            return redirect()->route('hang-hoa.index')->with(['status' => 'Sửa thông tin hàng hóa thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = HangHoa::destroy($id);
        if ($status) {
            return redirect()->route('hang-hoa.index')->with(['status' => 'Xóa hàng hóa thành công', 'type' => 'success']);
        } else{
            return back()->with(['status' => 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }
}
