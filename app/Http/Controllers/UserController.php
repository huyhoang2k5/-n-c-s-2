<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        return view('auth.profile.show');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Mật khẩu cũ không được để trống!',
            'password.required' => 'Mật khẩu mới không được để trống!',
            'password.min' => 'Bạn phải nhập ít nhất 8 kí tự!'
        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            Auth::logout();

            return redirect()->route('login')->with(['type' => 'success', 'status' => 'Thay đổi mật khẩu thành công thành công!']);
        }

        return back()->withErrors(['old_password' => 'Mật khẩu cũ bạn vừa nhập không chính xác!']);
    }

    public function updateProfile()
    {
        $request->validate([
            'name' => 'required|string',
            'dia_chi' => 'string|max:255',
        ], [
            'name.required' => 'Họ và tên không được để trống!',
            'dia_chi.max' => 'Độ dài cho phép tối đa là 255 kí tự!'
        ]);

        $user = Auth::user();

        $status = $user->update([
            'name' => $request->name,
            'dia_chi' => $user->dia_chi ?? ''
        ]);

        if ($status) {
            return back()->with(['status' => 'Thay đổi thông tin cá nhân thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Thay đổi thông tin cá nhân thất bại do lỗi.', 'type' => 'danger']);
        }
    }
}
