<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HangHoaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ten_hang_hoa' => 'required|max:255',
            'ma_hang_hoa' => 'required|max:100',
            'id_loai_hang' => 'required|integer',
            'don_vi_tinh' => 'required|max:50',
            'change_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'barcode' => 'max:100',
        ];
    }

    public function messages()
    {
        return [
            'ten_hang_hoa.required' => 'Tên hàng hóa không được để trống!',
            'ten_hang_hoa.max' => 'Độ dài cho phép tối đa là 255 kí tự!',
            'ma_hang_hoa.required' => 'Mã hàng hóa không được để trống!',
            'ma_hang_hoa.max' => 'Độ dài cho phép tối đa là 100 kí tự!',
            'id_loai_hang.required' => 'Loại hàng không được để trống',
            'id_loai_hang.integer' => 'Vui lòng chọn 1 trong các loại hàng bên dưới!',
            'don_vi_tinh.required' => 'Đơn vị tính không được để trống!',
            'don_vi_tinh.max' => 'Độ dài cho phép tối đa là 50 kí tự!',
            'change_img.image' => 'Sai định dạng của ảnh!',
            'change_img.mines' => 'CChỉ chấp nhận các loại tệp *.png, *.jpg and *.jpeg.',
            'barcode.max' => 'Độ dài cho phép tối đa là 100 kí tự!'
        ];
    }
}
