@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thông tin</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('nhap-kho.index') }}">Quản lý nhập kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $phieu_nhap->ma_phieu_nhap }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <div class="nk-invoice">
                                <div class="nk-invoice-head flex-column flex-sm-row">
                                    <div class="nk-invoice-head-item mb-3 mb-sm-0">
                                        <div class="h4">Chi tiết</div>
                                        <ul>
                                            <li>Tên người nhập: {{ $phieu_nhap->getUsers->name }}</li>
                                            <li>Gmail: {{ $phieu_nhap->getUsers->email }}</li>
                                            <li>Nhà cung cấp: {{ $phieu_nhap->getNhaCungCap->ten_ncc }}</li>
                                            <li>Mô tả: {{ $phieu_nhap->mo_ta }}</li>
                                        </ul>
                                    </div>
                                    <div class="nk-invoice-head-item text-sm-end">
                                        <div class="h3">Mã phiếu nhập: {{ $phieu_nhap->ma_phieu_nhap }}</div>
                                        <ul>
                                            <li>Ngày nhập: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu_nhap->ngay_nhap)->format('d-m-Y') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="nk-invoice-body">
                                    <div class="table-responsive">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                                    <th class="tb-col"><span class="overline-title">Mã hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">Tên hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                                    <th class="tb-col"><span class="overline-title">Giá nhập</span></th>
                                                    <th class="tb-col"><span class="overline-title">Thành tiền</span>
                                                    </th>
                                                    <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chi_tiet_phieu_nhap as $key => $chi_tiet)
                                                    <tr>
                                                        <td class="tb-col">
                                                            <span>{{ $key + 1 }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->ma_hang_hoa }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getHangHoa->ten_hang_hoa }}</span>
                                                        </td>
                                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong_goc }}</span></td>
                                                        <td class="tb-col"><span>{{ number_format($chi_tiet->gia_nhap, 0, '', '.') }} VNĐ</span></td>
                                                        <td class="tb-col">
                                                            <span>{{ number_format($chi_tiet->so_luong_goc * $chi_tiet->gia_nhap, 0, '', '.') }} VNĐ</span>
                                                        </td>
                                                        <td class="tb-col tb-col-end"><a class="btn btn-info btn-sm"
                                                                href="{{ route('hang-hoa.show', $chi_tiet->ma_hang_hoa) }}"><em
                                                                    class="icon ni ni-eye"></em><span>Xem</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="">Tổng:</td>
                                                    <td class="tb-col">{{ number_format($phieu_nhap->tong, 0, '', ',') }} VNĐ</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @include('parts.paginate', ['paginator' => $chi_tiet_phieu_nhap])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
