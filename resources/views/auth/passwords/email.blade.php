@extends('default')

@section('content')
    <div class="container p-2 p-sm-4">
        <div class="wide-xs mx-auto">
            <div class="card card-gutter-lg rounded-4 card-auth">
                <div class="card-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title mb-2">Quên mật khẩu</h3>
                            <p class="small">Hãy điền thông tin vào link bên dưới và chúng tôi sẽ gửi cho bạn link xác nhận!</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <div class="form-group"><label for="email-address" class="form-label">Email</label>
                                    <div class="form-control-wrap"><input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid"><button class="btn btn-primary" type="submit">Send Reset Link</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-5">
                <p class="small"><a href="{{ route('login') }}">Back to Login</a></p>
            </div>
        </div>
    </div>
@endsection
