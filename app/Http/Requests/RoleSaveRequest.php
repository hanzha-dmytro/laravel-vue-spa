<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleSaveRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:3|max:191',
            'slug'        => 'required|unique:roles,slug,'.$this->role?->id,
            'permissions' => 'nullable|array',
        ];
    }
}
