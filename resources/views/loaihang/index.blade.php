@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý loại hàng</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý loại hàng hóa</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                @can('user')
                                    <ul class="d-flex">
                                        <li><a href="{{ route('loai-hang.create') }}" class="btn btn-primary btn-md d-md-none"><em
                                                    class="icon ni ni-plus"></em><span>Thêm</span></a></li>
                                        <li><a href="{{ route('loai-hang.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em
                                                    class="icon ni ni-plus"></em><span>Thêm loại hàng</span></a>
                                        </li>
                                    </ul>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive" id="loai-hoa">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên loại hàng</span></th>
                                        <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                        <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">action</span></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($loai_hang as $key => $loai)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col">
                                                <div class="media-text"><a href="{{ route('loai-hang.show', $loai->id) }}"
                                                        class="title">{{ $loai->ten_loai_hang }}</a></div>
                                            </td>
                                            <td class="tb-col"><span>{{ $loai->getHangHoa->count() }}</span></td>
                                            <td class="tb-col">
                                                <span
                                                    class="badge text-bg-{{ $loai->id_trang_thai == 3 ? 'success' : ($loai->id_trang_thai == 2 ? 'warning' : 'danger') }}-soft">{{ $loai->getTrangThai->ten_trang_thai }}</span>
                                            </td>
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown"><a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em
                                                            class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                @can('user')
                                                                    <li><a href="{{ route('loai-hang.edit', $loai->id) }}"><em
                                                                                class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#xoaloaihang{{ $loai->id }}">
                                                                            <em class="icon ni ni-trash"></em>
                                                                            <span>Xóa</span>
                                                                        </a>
                                                                    </li>
                                                                @endcan
                                                                <li><a href="{{ route('loai-hang.show', $loai->id) }}"><em class="icon ni ni-eye"></em><span>Xem chi
                                                                            tiết</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @can('user')
                                            <div class="modal fade" id="xoaloaihang{{ $loai->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableLabel">Bạn
                                                                chắc chắc muốn xóa?
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Đồng ý
                                                            nghĩa là bạn muốn xóa toàn
                                                            bộ dữ liệu liên quan đến
                                                            loại hàng hóa này!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <form method="POST" action="{{ route('loai-hang.delete', $loai->id) }}" id="delete-form">
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

@section('script')
@endsection
