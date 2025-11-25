<?php

namespace Modules\Panel\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class CreateSettingRequest extends FormRequest
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
            'form.key' => 'required|string|max:255|unique:app_settings,key',
            'form.type' => 'required|string',
            'form.meta' => 'nullable',
            'form.is_translatable' => 'boolean',
            'form.translations.*.name' => 'required|string|max:255',
            'form.translations.*.value' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.group' => 'group',
            'form.key' => 'key',
            'form.type' => 'type',
            'form.meta' => 'meta',
            'form.is_translatable' => 'is translatable',
            'form.translations.*.name' => 'translation name',
            'form.translations.*.value' => 'translation value',
        ];
    }
}
