<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddSliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'image_path' => 'required|max:10000|mimes:jpg,JPG,png,PNG,GIF,gif', //a required, max 10000kb
            'description' => 'required',
            'link' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'max' => ':attribute không được vượt quá :max KB',
            'mimes' => ':attribute phải là hình ảnh, có đuôi jpg,png hoặc gif',
        ];
    }


    public function attributes()
    {
        return [
            'title' => 'Tiêu đề trang',
            'image_path'=>'Ảnh',
            'description' => 'mô tả ngắn',
            'link' => 'link',   
        ];
    }
}
