<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostSaveRequest extends FormRequest
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
            'category_id'  => 'required|integer|exists:categories,id',
            'name'         => 'required|max:191',
            'slug'         => 'required|max:191|unique:posts,slug,'.$this->post?->id,
            'description'  => 'required|string|max:500',
            'content'      => 'required|string|max:65535',
            'image'        => 'nullable|image|file|max:1024',
            'is_visible'   => 'required|boolean',
            'published_at' => 'nullable|date',
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
