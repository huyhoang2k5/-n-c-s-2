@extends('default')

@section('style')
    <style>
        .w-10 {
            width: 10%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                            <div class="nk-block-head-content">
                                <div class="d-flex flex-column flex-md-row align-items-md-center">
                                    <div class="media media-huge media-circle"><img src="{{ asset('storage/images/user/' . auth()->user()->avatar) }}"
                                            class="img-thumbnail" alt="">
                                    </div>
                                    <div class="mt-3 mt-md-0 ms-md-3">
                                        <h3 class="title mb-1">{{ auth()->user()->name }}</h3><span class="small">{{ auth()->user()->role ?? 'Member' }}</span>
                                        <ul class="nk-list-option pt-1">
                                            {{-- <li><em class="icon ni ni-map-pin"></em><span class="small">California, United States</span></li>
                                                <li><em class="icon ni ni-building"></em><span class="small">Softnio</span></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-block-head-content">
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#show-profile" type="button">Thông tin</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button">Sửa thông tin</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-password" type="button">Đổi mật khẩu</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="show-profile">
                        <div class="nk-block">
                            <div class="card card-gutter-md">
                                <div class="card-body">
                                    <div class="bio-block">
                                        <h4 class="bio-block-title">Thông tin</h4>
                                        <ul class="list-group list-group-borderless small">
                                            <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Họ và tên:</span><span
                                                    class="text">{{ auth()->user()->name }}</span></li>
                                            <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Email:</span><span
                                                    class="text">{{ auth()->user()->email }}</span></li>
                                            <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Địa chỉ:</span><span
                                                    class="text">{{ auth()->user()->address }}</span></li>
                                            <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Ngày đăng ký:</span><span
                                                    class="text">{{ auth()->user()->created_at->format('d-m-Y') }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="edit-profile">
                        <div class="nk-block">
                            <div class="card card-gutter-md">
                                <div class="card-body">
                                    <div class="bio-block">
                                        <h4 class="bio-block-title mb-4">Sửa thông tin cá nhân</h4>
                                        <form action="{{ route('user.updateProfile') }}" method="POST">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <div class="form-group"><label for="name" class="form-label">Họ và tên</label>
                                                        <div class="form-control-wrap"><input type="text" class="form-control" id="name"
                                                                placeholder="Họ tên" value="{{ auth()->user()->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group"><label for="dia_chi" class="form-label">Địa chỉ</label>
                                                        <div class="form-control-wrap"><input type="text" class="form-control" id="dia_chi"
                                                                placeholder="Địa chỉ" value="{{ auth()->user()->dia_chi }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12"><button class="btn btn-primary" type="submit">Xác nhận</button></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="edit-password">
                        <div class="nk-block">
                            <div class="card card-gutter-md">
                                <div class="card-body">
                                    <div class="bio-block">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('user.updatePassword') }}">
                                                @csrf

                                                <div class="row mb-3">
                                                    <label for="old_password" class="col-md-4 col-form-label text-md-end">Mậu khẩu cũ</label>

                                                    <div class="col-md-6">
                                                        <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror"
                                                            name="old_password" required autocomplete="current-password">

                                                        @error('old_password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="password" class="col-md-4 col-form-label text-md-end">Mật khẩu mới</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                            name="password" required autocomplete="new-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Nhập lại mật khẩu</label>
                                                    <div class="col-md-6">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                                            autocomplete="new-password">
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            Xác nhận
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
