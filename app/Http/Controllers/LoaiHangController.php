<?php

namespace App\Http\Controllers;

use App\Models\LoaiHang;
use App\Models\TrangThai;
use Illuminate\Http\Request;
use App\Http\Requests\LoaiHangRequest;

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
    public function store(LoaiHangRequest $request)
    {
        $data = $request->all();

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $loai_hang = LoaiHang::firstOrCreate([
            'ten_loai_hang' => $data['ten_loai_hang']
        ],
        [
            'ten_loai_hang' => $data['ten_loai_hang'],
            'trang_thai' => $data['trang_thai'],
            'mo_ta' => $mo_ta ?? 'Loại hàng này chưa có mô tả cụ thể!'

        ]);

        return redirect()->action([LoaiHangController::class, 'index'])->with('status-success', 'Thêm mới loại hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $trang_thai = TrangThai::get();
        $loai_hang = LoaiHang::findOrFail($id);
        // dd($loai_hang);

        return view('loaihang.edit', compact('loai_hang', 'trang_thai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $loai_hang = LoaiHang::findOrFail($id);
        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $loai_hang->ten_loai_hang = $data['ten_loai_hang'];
        $loai_hang->trang_thai = $data['trang_thai'];
        $loai_hang->mo_ta = $mo_ta;

        $loai_hang->save();

        if ($loai_hang->save()) {
            return redirect()->action([LoaiHangController::class, 'index'])->with('status-success', 'Sửa thông tin loại hàng thành công!');
        } else {
            return redirect()->back()->with('status-danger', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        LoaiHang::destroy($id);

        return redirect()
            ->route('loai-hang.index')
            ->with('status-success', 'Xóa loại hàng hóa thành công');
    }
}
