<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoaiHangRequest extends FormRequest
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
            'ten_loai_hang' => 'required|min:2|max:100|unique:loai_hang'
        ];
    }

    public function messages()
    {
        return [
            'ten_loai_hang.required' => 'Cần thêm tên loại hàng!',
            'ten_loai_hang.min' => 'Tên loại hàng phải lớn hơn 2 kí tự!',
            'ten_loai_hang.max' => 'Độ dài cho phép tối đa là 100 kí tự!',
            'ten_loai_hang.unique' => 'Tên loại hàng đã tồn tại!',
        ];
    }
}
