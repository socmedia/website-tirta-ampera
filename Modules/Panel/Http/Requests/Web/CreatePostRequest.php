<?php

namespace Modules\Panel\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'form.category_id' => 'required|integer|exists:categories,id',
            'form.type' => 'required|string|max:50',
            'form.thumbnail' => 'required',
            'form.content' => 'nullable|string',
            'form.tags' => 'nullable|string|max:255',
            'form.title' => 'required|string|max:191',
            'form.slug' => 'required|string|max:191',
            'form.subject' => 'required|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.category_id' => 'category',
            'form.type' => 'post type',
            'form.thumbnail' => 'thumbnail',
            'form.content' => 'content',
            'form.tags' => 'tags',
            'form.title' => 'title',
            'form.slug' => 'slug',
            'form.subject' => 'subject',
        ];
    }
}
