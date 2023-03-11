<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HangHoaStoreRequest extends FormRequest
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
            'ten_hang_hoa' => 'required|max:100',
            'ma_hang_hoa' => 'required|max:100|unique:hang_hoa,ma_hang_hoa',
            'id_loai_hang' => 'required|integer',
            'don_vi_tinh' => 'required|max:50'
        ];
    }

    public function messages()
    {
        return [
            'ten_hang_hoa.required' => 'Tên hàng hóa không được để trống!',
            'ten_hang_hoa.max' => 'Độ dài cho phép tối đa là 100 kí tự!',
            'ma_hang_hoa.required' => 'Tên loại hàng không được để trống!',
            'ma_hang_hoa.max' => 'Độ dài cho phép tối đa là 100 kí tự!',
            'ma_hang_hoa.unique' => 'Mã hàng hóa đã tồn tại!',
            'id_loai_hang.required' => 'Loại hàng không được để trống',
            'id_loai_hang.integer' => 'Vui lòng chọn 1 trong các loại hàng bên dưới!',
            'don_vi_tinh.required' => 'Đơn vị tính không được để trống!',
        ];
    }
}
