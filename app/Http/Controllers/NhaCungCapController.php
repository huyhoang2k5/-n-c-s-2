<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class NhaCungCapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nha_cung_cap = NhaCungCap::get();

        return view('nhacungcap.index', compact('nha_cung_cap'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nhacungcap.create');
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
            'mo_ta' => $mo_ta
        ]);

        if ($nha_cung_cap->wasRecentlyCreated) {
            return redirect()->action([NhaCungCapController::class, 'index'])->with('status-success', 'Thêm mới nhà cung cấp thành công!');
        } else {
            return redirect()->back()->with('status-error', 'Thêm mới thất bại do đã tồn tại nhà cung cấp từ trước hoặc do lỗi!')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NhaCungCap $nhaCungCap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $nha_cung_cap = NhaCungCap::findOrFail($id);

        return view('nhacungcap.edit', compact('nha_cung_cap'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sdt' => 'required|regex:/(0)[0-9]{9}/'
        ], [
            'sdt.required' => 'Bạn cần thêm số điện thoại!',
            'sdt.regex' => 'Định dạng số điện thoại không đúng.'
        ]);

        $data = $request->all();

        $nha_cung_cap = NhaCungCap::findOrFail($id);

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $nha_cung_cap->ma_ncc = $data['ma_ncc'];
        $nha_cung_cap->ten_ncc = $data['ten_ncc'];
        $nha_cung_cap->dia_chi = $data['dia_chi'];
        $nha_cung_cap->sdt = $data['sdt'];
        $nha_cung_cap->mo_ta = $mo_ta;

        $nha_cung_cap->save();

        if ($nha_cung_cap->save()) {
            return redirect()->action([NhaCungCapController::class, 'index'])->with('status-success', 'Sửa thông tin nhà cung cấp thành công!');
        } else {
            return redirect()->back()->with('status-danger', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        NhaCungCap::destroy($id);

        return redirect()
            ->route('nha-cung-cap.index')
            ->with('status-success', 'Xóa nhà cung cấp thành công');
    }
}
