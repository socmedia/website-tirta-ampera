<?php

namespace Modules\Panel\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'form.group' => 'required|string',
            'form.meta' => 'nullable',
            'form.featured' => 'boolean',
            'form.translations.*.name' => 'required|string|max:255',
            'form.translations.*.description' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.group' => 'group',
            'form.meta' => 'meta',
            'form.featured' => 'is featured',
            'form.translations.*.name' => 'translation name',
            'form.translations.*.description' => 'translation description',
        ];
    }
}
