<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoaiHangStoreRequest extends FormRequest
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
            'ten_loai_hang' => 'required|max:255|unique:loai_hang,ten_loai_hang',
            'id_trang_thai' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'ten_loai_hang.required' => 'Vui lòng nhập tên loại hàng',
            'ten_loai_hang.max' => 'Tên loại hàng không được vượt quá :max ký tự',
            'ten_loai_hang.unique' => 'Tên loại hàng đã tồn tại, vui lòng chọn tên khác',
            'id_trang_thai.required' => 'Vui lòng chọn trạng thái',
            'id_trang_thai.integer' => 'Vui lòng không truyền sai tham số vào trạng thái'
        ];
    }
}
