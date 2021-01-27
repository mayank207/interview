<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
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
        $user_id = Auth::id();

        return [
            'hrname'=>"required|min:2|max:20",
            'hremail'=>'required|email|unique:users,email',
            'hrpassword' => ['required','string','same:confirm-password','min:8','max:20','regex:/[a-z]/',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/'],
            'confirm-password'=>"required"
        ];
    }

    public function messages()
    {
        return[
            'hrname.required'=>"Name field is required",
            'hrname.min'=>"The name must be at least 2 characters.",
            'hrname.max'=>"The name must be at least 20 characters.",
            'hremail.required'=>"Email field is required",
            'hremail.email'=>"Email field is required",
            'hremail.unique'=>"The email has already been taken.",
            'hrpassword.required'=>"Password field is required",
            'hrpassword.same'=>"The password and confirm-password must match.",
            'hrpassword.min'=>"The password must be at least 8 characters.",
            'hrpassword.max'=>"The password must be at least 20 characters.",
            'hrpassword.regex'=>"The password At Least 8 Characters,Mixer Of Uper & Lower Case,Numberic,At Least One special character.",
            'hrconfirm-password.required'=>"Confirm Password field is required",
        ];
    }
}
