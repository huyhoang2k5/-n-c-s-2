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
                                        <li class="breadcrumb-item"><a href="{{ route('hang-hoa.index') }}">Quản lý kho</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('nhap-kho.show', $phieu_nhap->ma_phieu_nhap) }}">{{ $phieu_nhap->ten_phieu_nhap }}</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Thông tin
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li><a href="{{ route('nhap-kho.create') }}"
                                            class="btn btn-primary btn-md d-md-none"><em
                                                class="icon ni ni-plus"></em><span>Thêm</span></a></li>
                                    <li><a href="{{ route('nhap-kho.create') }}"
                                            class="btn btn-primary d-none d-md-inline-flex"><em
                                                class="icon ni ni-plus"></em><span>Thêm hàng vào kho</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mã
                                            phiếu nhập:</span><span class="text">{{ $phieu_nhap->ma_phieu_nhap }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Tên
                                            người nhập:</span><span class="text">{{ $phieu_nhap->getUsers->name }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Ngày
                                            nhập:</span><span
                                            class="text">{{ $phieu_nhap->getLoaiHang->ten_loai_hang }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <table class="datatable-init table" data-nk-container="table-responsive" id="hang-hoa">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col"><span class="overline-title">ID</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Số lượng gốc</span></th>
                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Giá nhập</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Ngày sản xuất</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Bảo quản(tháng)</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false"><span
                                            class="overline-title">action</span></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($chi_tiet_phieu_nhap as $chi_tiet)
                                    <tr>
                                        <td class="tb-col">
                                            <span>#{{ $chi_tiet->id }}</span>
                                        </td>
                                        <td class="tb-col tb-col-md"><span>{{ $chi_tiet->so_luong_goc }}</span></td>
                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong }}</span></td>
                                        <td class="tb-col tb-col-md"><span>{{ $chi_tiet->gia_nhap }}</span></td>
                                        <td class="tb-col tb-col-md">
                                            <span>{{ $chi_tiet->ngay_san_xuat }}</span>
                                        </td>
                                        <td class="tb-col tb-col-md">
                                            <span class="tb-col tb-col-md">{{ $chi_tiet->tg_bao_quan }}</span>
                                        </td>
                                        <td class="tb-col tb-col-end"><a class="btn btn-primary btn-sm"
                                                href="{{ route('nhap-kho.show', $chi_tiet->id) }}"><em
                                                    class="icon ni ni-eye"></em><span>Xem chi tiết</span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
