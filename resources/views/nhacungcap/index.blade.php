@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Nhà cung cấp</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Nhà cung cấp</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                @can('user')
                                    <ul class="d-flex">
                                        <li><a href="{{ route('nha-cung-cap.create') }}" class="btn btn-primary d-md-inline-flex"><em
                                                    class="icon ni ni-plus"></em><span>Thêm nhà cung cấp</span></a>
                                        </li>
                                    </ul>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">Mã nhà cung cấp</span>
                                        </th>
                                        <th class="tb-col"><span class="overline-title">Tên nhà cung cấp</span></th>
                                        <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nha_cung_cap as $ncc)
                                        <tr>
                                            <td class="tb-col"><span>{{ $ncc->ma_ncc }}</span></td>
                                            <td class="tb-col">
                                                <div class="media-text"><a href="{{ route('nha-cung-cap.show', $ncc->ma_ncc) }}"
                                                        class="title">{{ $ncc->ten_ncc }}</a></div>
                                            </td>
                                            <td class="tb-col"><span
                                                    class="badge text-bg-{{ $ncc->id_trang_thai == 3 ? 'success' : ($ncc->id_trang_thai == 2 ? 'warning' : 'danger') }}-soft">{{ $ncc->getTrangThai->ten_trang_thai }}</span>
                                            </td>
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown"><a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em
                                                            class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                @can('user')
                                                                <li><a href="{{ route('nha-cung-cap.edit', $ncc->ma_ncc) }}"><em
                                                                            class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                </li>
                                                                @endcan
                                                                <li><a href="{{ route('nha-cung-cap.show', $ncc->ma_ncc) }}"><em
                                                                            class="icon ni ni-eye"></em><span>Xem chi
                                                                            tiết</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
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
