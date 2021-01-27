<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteRequest extends FormRequest
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
// clear error
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'notetitle'=>"required|max:20|min:3",
            'description'=>"required|max:35"
        ];
    }
    public function messages()
    {
        return[
            'notetitle.required'=>'Title is required',
            'notetitle.min'=>'Title at least 3 characters.',
            'notetitle.max'=>'Title at least 20 characters.',
            'description.max'=>'Title at least 35 characters.',
            'description.required'=>'Description is required',
        ];
    }
}