<?php

namespace Modules\Panel\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class CreateSliderRequest extends FormRequest
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
            'form.type' => 'required|string|max:50',
            'form.desktop_media_path.*' => 'required',
            'form.heading' => 'required|string|max:191',
            'form.sub_heading' => 'nullable|string|max:50',
            'form.description' => 'nullable|string|max:191',
            'form.button_text' => 'nullable|string|max:100',
            'form.button_url' => 'nullable|string|max:191',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.status' => 'status',
            'form.type' => 'slider type',
            'form.desktop_media_path' => 'slider image',
            'form.heading' => 'heading',
            'form.sub_heading' => 'sub heading',
            'form.description' => 'description',
            'form.button_text' => 'button text',
            'form.button_url' => 'button url',
        ];
    }
}
