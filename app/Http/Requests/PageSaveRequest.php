<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageSaveRequest extends FormRequest
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
            'name'         => 'required|max:191',
            'slug'         => 'required|max:191|unique:posts,slug,'.$this->post?->id,
            'content'      => 'nullable|string|max:65535',
            'is_visible'   => 'required|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_visible' => filter_var($this->is_visible, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }
}
