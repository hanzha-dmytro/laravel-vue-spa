<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSaveRequest extends FormRequest
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
            'name'                  => 'required|string|min:3|max:24|unique:users,name,'.$this->user()?->id,
            'email'                 => 'required|email|unique:users,email,'.$this->user()?->id,
            'description'           => 'nullable|string|max:500',
            'avatar'                => 'nullable|image|file|max:1024',
            'password'              => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable:min:8',
        ];
    }
}
