<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user');
    }


    public function index()
    {
        return view('taikhoan.index');
    }

    public function show()
    {
        return view('auth.profile');
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


    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dia_chi' => 'string|max:255',
            'sdt' => 'required|regex:/(0)[0-9]{9}/',
            'change_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        dd($request);
        $file_name = auth()->user()->avatar;
        $file_name1 = auth()->user()->avatar;

        if ($request->hasFile('change_img') && $file_name != $request->change_img) {
            $img = $request->file('change_img');
            $file_name1 = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/user', $file_name1);
        }

        $user = auth()->user();

        $status = $user->update([
            'name' => $request->name,
            'dia_chi' => $user->dia_chi ?? '',
            'avatar' => $file_name1,
            'sdt' => $request->sdt,
            'gioi_tinh' => $request->gioi_tinh
        ]);

        if ($status) {
            if ($request->hasFile('change_img') && $file_name != $request->change_img && $file_name != 'avatar.jpg') {
                unlink(storage_path('app/public/images/user'.$file_name));
            };
            return back()->with(['status' => 'Thay đổi thông tin cá nhân thành công!', 'type' => 'success']);
        } else {
            return back()->with(['status' => 'Thay đổi thông tin cá nhân thất bại do lỗi.', 'type' => 'danger']);
        }
    }

}
