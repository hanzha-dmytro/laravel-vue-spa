<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
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
            'role_id'     => 'required|integer|exists:roles,id',
            'name'        => 'required|string|min:3|max:24|unique:users,name,'.$this->user?->id,
            'email'       => 'required|email|unique:users,email,'.$this->user?->id,
            'password'    => 'nullable|string|min:8|max:18',
            'is_active'   => 'required|boolean',
            'permissions' => 'nullable|array',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => filter_var($this->is_active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }
}
