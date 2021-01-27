<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'hrname'=>"required|max:20|min:2",
            'hremail'=>'unique:users,email,'.$this->get('hrid').'|email',
        ];
    }

    public function messages()
    {
        return[
            'hrname.required'=>'Name is required',
            'hremail.required'=>'Email is required',
            'hremail.email'=>'Email is not proper format',
            'hremail.unique'=>'Email is already taken',
            'hrname.min'=>'The hrname must be at least 2 characters.',
            'hrname.max'=>'The hrname must be at least 20 characters.',
            'hrname.max'=>'The hrname must be at least 20 characters.',
        ];
    }
}
