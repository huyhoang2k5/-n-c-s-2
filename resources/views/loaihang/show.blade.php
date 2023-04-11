@extends('default')

@section('style')
    <style>
        .w-10 {
            width: 10% !important;
        }
    </style>
@endsection

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
                                        <li class="breadcrumb-item"><a href="{{ route('loai-hang.index') }}">Quản lý loại
                                                hàng</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            {{ $loai_hang->ten_loai_hang }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li><a href="{{ route('loai-hang.edit', $loai_hang->id) }}" class="btn btn-primary d-md-inline-flex"><em
                                                class="icon ni ni-edit"></em></em><span>Sửa loại hàng</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item">
                                        <span class="title fw-medium w-10 d-inline-block">Tên
                                            loại hàng:</span>
                                        <span class="text">{{ $loai_hang->ten_loai_hang }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Trạng
                                            thái:</span><span
                                            class="badge text-bg-{{ $loai_hang->id_trang_thai == 3 ? 'success' : ($loai_hang->id_trang_thai == 2 ? 'warning' : 'danger') }}-soft">{{ $loai_hang->getTrangThai->ten_trang_thai }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Mô
                                            tả:</span><span class="text"> {!! $loai_hang->mo_ta !!}</span></li>
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
                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                    <th class="tb-col"><span class="overline-title">Mã hàng</span></th>
                                    <th class="tb-col"><span class="overline-title">Tên hàng</span></th>
                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                    <th class="tb-col"><span class="overline-title">Đơn vị</span></th>
                                    <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                    <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">action</span></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($hang_hoa as $key => $hang)
                                    <tr>
                                        <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                        <td class="tb-col"><span>{{ $hang->ma_hang_hoa }}</span></td>
                                        <td class="tb-col">
                                            <div class="media-group">
                                                <div class="media media-lg media-middle"><img src="{{ asset('storage/images/hanghoa/' . $hang->img) }}"
                                                        alt="img"></div>
                                                <div class="media-text"><a href="{{ route('hang-hoa.show', $hang->ma_hang_hoa) }}"
                                                        class="title">{{ $hang->ten_hang_hoa }}</a></div>
                                            </div>
                                        </td>
                                        @php
                                            $so_luong = 0;
                                            foreach ($hang->getChiTiet as $value) {
                                                $so_luong += $value->so_luong;
                                            }
                                        @endphp
                                        <td class="tb-col"><span>
                                                {{ $so_luong }}
                                            </span></td>
                                        <td class="tb-col"><span>{{ $hang->don_vi_tinh }}</span></td>
                                        <td class="tb-col">
                                            <span
                                                class="badge text-bg-{{ $so_luong > 0 ? 'success' : 'danger' }}-soft">{{ $so_luong > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                        </td>
                                        <td class="tb-col tb-col-end">
                                            <div class="dropdown"><a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em
                                                        class="icon ni ni-more-v"></em></a>
                                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                    <div class="dropdown-content py-1">
                                                        <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                            @can('user')
                                                                <li><a href="{{ route('hang-hoa.edit', $hang->ma_hang_hoa) }}"><em
                                                                            class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                </li>
                                                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#xoa_hang_hoa"><em
                                                                            class="icon ni ni-trash"></em><span>Xóa</span></a>
                                                                </li>
                                                            @endcan
                                                            <li><a href="{{ route('hang-hoa.show', $hang->ma_hang_hoa) }}"><em
                                                                        class="icon ni ni-eye"></em><span>Xem chi
                                                                        tiết</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @can('user')
                                        <div class="modal fade" id="xoa_hang_hoa" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="scrollableLabel">Bạn
                                                            chắc chắc muốn xóa?
                                                        </h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">Đồng ý
                                                        nghĩa là bạn muốn xóa toàn
                                                        bộ dữ liệu liên quan đến hàng hóa này!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        <form method="POST" action="{{ route('hang-hoa.delete', $hang->id) }}" id="delete-form">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-sm btn-primary">Đồng
                                                                ý</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
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
