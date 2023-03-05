<?php

namespace App\Http\Controllers;

use App\Models\HangHoa;
use App\Models\LoaiHang;
use App\Models\ChiTietHangHoa;
use Illuminate\Http\Request;
use Storage;

class HangHoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hang_hoa = [];

        HangHoa::orderBy('id')->chunkById(100, function ($chunk) use (&$hang_hoa) {
            foreach ($chunk as $hang) {
                if ($hang->getLoaiHang->trang_thai != 1) {
                    $hang_hoa[] = $hang;
                }
            }
        });

        return view('khohang.index', compact('hang_hoa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $loai_hang = LoaiHang::where('trang_thai', '=', 3)->get();

        return view('khohang.create', compact('loai_hang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $file_name = "hanghoa.jpg";

        if ($request->hasFile('change_img')) {
            $img = $request->file('change_img');
            $file_name = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/hanghoa', $file_name);
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $hang_hoa = HangHoa::firstOrCreate([
            'ma_hang_hoa' => $data['ma_hang_hoa']
        ],
        [
            'ma_hang_hoa' => $data['ma_hang_hoa'],
            'ten_hang_hoa' => $data['ten_hang_hoa'],
            'id_loai_hang' => $data['loai_hang_hoa'],
            'don_vi_tinh' => $data['don_vi_tinh'],
            'barcode' => $data['barcode'] ?? '',
            'img' => $file_name,
            'mo_ta' => $mo_ta
        ]);

        if ($hang_hoa->wasRecentlyCreated) {
            return redirect()->action([HangHoaController::class, 'index'])->with('status-success', 'Thêm mới hàng hóa thành công!');
            // user just created in the database; it didn't exist before.
            // return redirect()->route('khohang.index')->with('status', 'Thêm mới hàng hóa thành công!');
        } else {
            // user already existed and was pulled from database.
            return redirect()->back()->with('status-error', 'Thêm mới thất bại do đã tồn tại hàng hóa từ trước hoặc do lỗi!')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $chi_tiet_hang_hoa = ChiTietHangHoa::where('ma_hang_hoa', $code)->get();

        return view('khohang.show', compact('hang_hoa', 'chi_tiet_hang_hoa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code)
    {
        $loai_hang = LoaiHang::where('trang_thai', '=', 3)->get();
        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();

        return view('khohang.edit', compact('hang_hoa', 'loai_hang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $data = $request->all();

        $hang_hoa = HangHoa::where('ma_hang_hoa', $code)->firstOrFail();
        $file_name = $hang_hoa->img;

        if ($request->hasFile('change_img')) {
            $img = $request->file('change_img');
            $file_name = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/hanghoa', $file_name);
            unlink(storage_path('app/public/images/hanghoa/'.$hang_hoa->img));
        }

        $mo_ta = json_decode($request->mo_ta)->ops[0]->insert;

        $hang_hoa->ma_hang_hoa = $data['ma_hang_hoa'];
        $hang_hoa->ten_hang_hoa = $data['ten_hang_hoa'];
        $hang_hoa->id_loai_hang = $data['loai_hang_hoa'];
        $hang_hoa->don_vi_tinh = $data['don_vi_tinh'];
        $hang_hoa->barcode = $data['barcode'];
        $hang_hoa->img = $file_name;
        $hang_hoa->mo_ta = $mo_ta;


        $hang_hoa->save();

        if ($hang_hoa->save()) {
            return redirect()->action([HangHoaController::class, 'index'])->with('status-success', 'Sửa thông tin hàng hóa thành công!');
        } else {
            return redirect()->back()->with('status-danger', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        HangHoa::destroy($id);

        return redirect()
            ->route('hang-hoa.index')
            ->with('status-success', 'Xóa hàng hóa thành công');
    }
}
