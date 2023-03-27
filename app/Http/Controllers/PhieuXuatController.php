<?php

namespace App\Http\Controllers;
use App\Models\PhieuXuat;
use App\Models\HangHoa;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietHangHoa;
use App\Exports\PhieuXuatExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Illuminate\Http\Request;

class PhieuXuatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ma_phieu_xuat = PhieuXuat::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        $phieu_xuat = [];

        PhieuXuat::orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$phieu_xuat) {
            foreach ($chunk as $phieu) {
                $phieu_xuat[] = $phieu;
            }
        });

        return view('xuatkho.index', compact('phieu_xuat', 'ma_phieu_xuat'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $ma_phieu_xuat = PhieuXuat::latest()->first()->ma_phieu_xuat ?? "PX000000";

        $lastNumber = (int) substr($ma_phieu_xuat, 2);
        $lastNumberLength = strlen((string)substr($ma_phieu_xuat, 2));
        $nextNumber = $lastNumber + 1;
        $ma_phieu_xuat = 'PX' . str_pad($nextNumber, $lastNumberLength, '0', STR_PAD_LEFT);

        return view('xuatkho.create', compact('ma_phieu_xuat'));
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
    public function show($code)
    {
        $phieu_xuat = PhieuXuat::where('ma_phieu_xuat', $code)->firstOrFail();

        $chi_tiet_phieu_xuat = [];

        ChiTietPhieuXuat::where('ma_phieu_xuat', $code)->orderBy('id', 'DESC')->chunkById(100, function ($chunk) use (&$chi_tiet_phieu_xuat) {
            foreach ($chunk as $chi_tiet) {
                $chi_tiet_phieu_xuat[] = $chi_tiet;
            }
        });

        return view('xuatkho.show', compact('phieu_xuat', 'chi_tiet_phieu_xuat'));
    }

    public function export(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dataExport = [];

        try {
            if (count($data) > 1) {
                $mo_ta = json_decode($data[0]['mo_ta'], true) ?? 'Chưa có mô tả cụ thể!';

                $phieu_xuat = PhieuXuat::firstOrCreate(
                    ['ma_phieu_xuat' => $data[0]['ma_phieu_xuat']],
                    [
                    'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                    'khach_hang' => $data[0]['khach_hang'],
                    'dia_chi' => $data[0]['dia_chi'],
                    'ngay_xuat' => $data[0]['ngay_xuat'],
                    'id_user' => $data[0]['id_user'],
                    'mo_ta' => $mo_ta
                ]);

                if ($phieu_xuat->wasRecentlyCreated) {

                    for ($i = 1; $i < count($data); $i++) {
                        $cthh = ChiTietHangHoa::find($data[$i]['id_hang_hoa']);
                        $hh = HangHoa::where('ma_hang_hoa', $cthh->ma_hang_hoa)->first();

                        ChiTietPhieuXuat::create([
                            'ma_phieu_xuat' => $data[0]['ma_phieu_xuat'],
                            'id_chi_tiet_hang_hoa' => $data[$i]['id_hang_hoa'],
                            'so_luong' => $data[$i]['so_luong'],
                            'gia_xuat' => $data[$i]['gia']
                        ]);

                        $item = [];
                        $item[] = $i;
                        $item[] = $cthh->ma_hang_hoa;
                        $item[] = $hh->ten_hang_hoa;
                        $item[] = $hh->don_vi_tinh;
                        $item[] = $data[$i]['so_luong'];
                        $item[] = $data[$i]['gia'];
                        $item[] = $data[$i]['so_luong'] * $data[$i]['gia'];

                        $dataExport[] = $item;

                        $cthh->so_luong -= $data[$i]['so_luong'];
                        $cthh->so_luong == 0 ?? $cthh->trang_thai = 1;
                        $cthh->save();
                    }

                    $excel = Excel::download(new PhieuXuatExport($dataExport), 'xuat-kho.xlsx', \Maatwebsite\Excel\Excel::XLSX);

                    $excelPath = $excel->getFile()->getPathname();
                    \Storage::disk('public')->put('excel/xuat-kho.xlsx', file_get_contents($excelPath));

                    return response()->json(['type' => 'export', 'message' => 'Xuất file excel thành công. Bạn có muốn tải về không?', 'downloadUrl' => route('xuat-kho.download')]);
                }

                PhieuXuat::delete($phieu_xuat->id);

                return response()->json(['message'=> 'Mã phiếu xuất đã tồn tại. Vui lòng tải lại trang để được nhận mã phiểu mới!']);
            }

        } catch (\Throwable $th) {

            return back()->with(['message'=> 'Có lỗi xảy ra trong quá trình xuất dữ liệu. Vui lòng kiểm tra và thử lại!']);
        }
    }

    public function download()
    {
        $file = public_path('storage/excel/xuat-kho.xlsx');
        return response()->download($file, 'xuat-kho.xlsx');
    }
}
