<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name'=>'required|string|max:255|' ,
            'email'=>'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:8|',
            'password-confirm' => 'required_with:password|same:password|string|min:8|' ,
        ];
    }
    public function messages()
    {
      return[
        'required'=>':attribute  không được để trống',
        'max'=>':attribute không được quá :max ky tu',
        'min'=>'attribute không được dưới :min ky tu',
        'confirmed'=>'Xác nhận mất khẩu không thành công',
      ];
  }

  public function attributes()
  {
    return[
      'name'=>'Tên người dùng',
      'email'=>'Email',
      'password'=>'mật khẩu',
    ];
}



}
