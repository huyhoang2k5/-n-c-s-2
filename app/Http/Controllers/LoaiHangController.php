<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
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
        $loai_hang = [];

        LoaiHang::orderBy('id')->chunkById(100, function ($chunk) use (&$loai_hang) {
            foreach ($chunk as $loai) {
                $loai_hang[] = $loai;
            }
        });

        return view('loaihang.index', compact('loai_hang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trang_thai = TrangThai::get();

        return view('loaihang.create', compact('trang_thai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoaiHangStoreRequest $request)
    {
        $data = $request->all();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert ?? 'Loại hàng này chưa có mô tả cụ thể!';

        $status = LoaiHang::create([
            'ten_loai_hang' => $data['ten_loai_hang'],
            'id_trang_thai' => $data['id_trang_thai'] ?? 3,
            'mo_ta' => $mo_ta
        ]);

        if ($status) {
            Alert::success('Thành công', 'Thêm mới loại hàng thành công!');
            return redirect()->route('loai-hang.index');
        } else {
            Alert::error('Thất bại', 'Thêm mới loại hàng thất bại do lỗi hoặc đã tồn tại trước đó!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loai_hang = LoaiHang::find($id);
        $hang_hoa = HangHoa::where('id_loai_hang', $id)->get();

        if ($loai_hang) {
            return view('loaihang.show', compact('loai_hang', 'hang_hoa'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy loại hàng, xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $loai_hang = LoaiHang::findOrFail($id);
        $trang_thai = TrangThai::get();

        return view('loaihang.edit', compact('loai_hang', 'trang_thai'));
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
            'id_trang_thai' => $data['id_trang_thai'],
            'mo_ta' => $mo_ta
        ]);

        if ($status) {
            Alert::success('Thành công', 'Sửa thông tin loại hàng thành công!');
            return redirect()->route('loai-hang.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = LoaiHang::destroy($id);

        if ($status) {
            Alert::success('Thành công', 'Xóa loại hàng hóa thành công!');
            return redirect()->route('loai-hang.index');
        } else{
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
}
