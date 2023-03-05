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
                                            <li class="breadcrumb-item"><a href="{{ route('hang-hoa.index') }}">Quản lý kho</a></li>
                                            <li class="breadcrumb-item"><a href="{{ route('hang-hoa.show', $hang_hoa->ma_hang_hoa) }}">{{ $hang_hoa->ten_hang_hoa }}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Thông tin
                                            </li>
                                        </ol>
                                    </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li><a href="{{ route('nhap-kho.create') }}" class="btn btn-primary btn-md d-md-none"><em
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
                        <div class="col-md-6 mb-5"><img src="{{ asset('storage/images/hanghoa/' . $hang_hoa->img) }}"
                                alt="{{ $hang_hoa->ten_hang_hoa }}" width="400" style="max-height: 300px; height: auto"
                                class="rounded mx-auto d-block">
                        </div>
                        <div class="col-md-6 card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mã
                                            hàng hóa:</span><span class="text">{{ $hang_hoa->ma_hang_hoa }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Tên
                                            hàng hóa:</span><span class="text">{{ $hang_hoa->ten_hang_hoa }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Loại
                                            hàng hóa:</span><span
                                            class="text">{{ $hang_hoa->getLoaiHang->ten_loai_hang }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Đơn
                                            vị:</span><span class="text">{{ $hang_hoa->don_vi_tinh }}</span></li>
                                    <li class="list-group-item"><span
                                            class="title fw-medium w-40 d-inline-block">Barcode:</span><span class="text">
                                            {{ $hang_hoa->barcode }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mô
                                            tả:</span><span class="text"> {!! $hang_hoa->mo_ta !!}</span></li>
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
                                    <th class="tb-col tb-col-md"><span class="overline-title">ID</span></th>
                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Giá nhập</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Ngày nhập</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Ngày sản xuất</span></th>
                                    <th class="tb-col tb-col-md"><span class="overline-title">Bảo quản(tháng)</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false"><span
                                            class="overline-title">action</span></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($chi_tiet_hang_hoa as $chi_tiet)
                                    <tr>
                                        <td class="tb-col tb-col-md">
                                            <span>#{{ $chi_tiet->id }}</span>
                                        </td>
                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong }}</span></td>
                                        <td class="tb-col tb-col-md"><span>{{ $chi_tiet->gia_nhap }}</span></td>
                                        <td class="tb-col tb-col-md">
                                            <span>{{ $chi_tiet->get }}</span>
                                        </td>
                                        <td class="tb-col tb-col-md">
                                            <span>{{ $chi_tiet->ngay_san_xuat }}</span>
                                        </td>
                                        <td class="tb-col tb-col-md">
                                            <span class="tb-col tb-col-md">{{ $chi_tiet->tg_bao_quan }}</span>
                                        </td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown"><a href="#"
                                                    class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-v"></em></a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            <li><a href=""><em
                                                                        class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                            </li>
                                                            <li><a href="#" data-bs-toggle="modal"
                                                                    data-bs-target="#xoa_hang_hoa"><em
                                                                        class="icon ni ni-trash"></em><span>Xóa</span></a>
                                                            </li>
                                                            <li><a href=""><em
                                                                        class="icon ni ni-eye"></em><span>Xem chi
                                                                        tiết</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="xoa_hang_hoa" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="scrollableLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-top">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableLabel">Bạn
                                                        chắc chắc muốn xóa?
                                                    </h5> <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">Đồng ý
                                                    nghĩa là bạn muốn xóa toàn
                                                    bộ dữ liệu liên quan đến hàng hóa này!
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <form method="POST"
                                                        action=""
                                                        id="delete-form">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm btn-primary">Đồng
                                                            ý</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
