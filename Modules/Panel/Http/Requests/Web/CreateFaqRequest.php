<?php

namespace Modules\Panel\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CreateFaqRequest extends FormRequest
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
            'form.status' => 'boolean',
            'form.featured' => 'boolean',
            'form.question' => 'required|string|max:255',
            'form.answer' => 'required|string|max:2000',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.status' => 'status',
            'form.featured' => 'is featured',
            'form.question' => 'question',
            'form.answer' => 'answer',
        ];
    }
}
