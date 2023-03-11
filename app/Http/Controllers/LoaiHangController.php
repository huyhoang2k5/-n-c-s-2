<?php

namespace App\Http\Controllers;

use App\Models\LoaiHang;
use App\Models\HangHoa;
use App\Models\TrangThai;
use Illuminate\Http\Request;
use App\Http\Requests\LoaiHangStoreRequest;
use App\Http\Requests\LoaiHangUpdateRequest;

class LoaiHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Quản lý loại hàng";
        $loai_hang = [];

        LoaiHang::orderBy('id')->chunkById(100, function ($chunk) use (&$loai_hang) {
            foreach ($chunk as $loai) {
                $loai_hang[] = $loai;
            }
        });

        return view('loaihang.index', compact('loai_hang', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới loại hàng';
        $trang_thai = TrangThai::get();

        return view('loaihang.create', compact('trang_thai', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoaiHangStoreRequest $request)
    {
        $data = $request->all();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Loại hàng này chưa có mô tả cụ thể!';

        $status = LoaiHang::firstOrCreate([
            'ten_loai_hang' => $data['ten_loai_hang']
        ],
        [
            'ten_loai_hang' => $data['ten_loai_hang'],
            'trang_thai' => $data['trang_thai'] ?? 3,
            'mo_ta' => $mo_ta
        ]);

        if ($status) {
            return redirect()->route('loai-hang.index')->with(['status' => 'Thêm mới loại hàng thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Thêm mới loại hàng thất bại do lỗi hoặc đã tồn tại trước đó', 'type' => 'danger']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loai_hang = LoaiHang::findOrFail($id);
        $title = $loai_hang->ten_loai_hang;
        $hang_hoa = HangHoa::where('id_loai_hang', $id)->get();

        if ($loai_hang) {
            return view('loaihang.show', compact('loai_hang', 'hang_hoa', 'title'));
        } else {
            return back()->with(['status' => 'Không tìm thấy loại hàng, xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loai_hang = LoaiHang::findOrFail($id);
        $title = "Sửa thông tin " . $loai_hang->ten_loai_hang;
        $trang_thai = TrangThai::get();

        return view('loaihang.edit', compact('loai_hang', 'trang_thai', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LoaiHangUpdateRequest $request, $id)
    {
        $data = $request->all();
        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Loại hàng này chưa có mô tả cụ thể!';

        $loai_hang = LoaiHang::findOrFail($id);
        $status = $loai_hang->update([
            'ten_loai_hang' => $data['ten_loai_hang'],
            'trang_thai' => $data['trang_thai'],
            'mo_ta' => $data['mo_ta']
        ]);

        if ($status) {
            return redirect()->route('loai-hang.index')->with(['status' => 'Sửa thông tin loại hàng thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = LoaiHang::destroy($id);

        if ($status) {
            return redirect()->action([LoaiHangController::class, 'index'])->with(['status' => 'Xóa loại hàng hóa thành công', 'type' => 'success']);
        } else{
            return back()->with(['status' => 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!', 'type' => 'danger']);
        }
    }
}
