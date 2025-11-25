<?php

namespace Modules\Panel\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class EditSettingRequest extends FormRequest
{
    /**
     * Optional form data for service-layer or manual validation.
     *
     * @var array<string, mixed>
     */
    protected array $form = [];

    /**
     * Setting ID for the update scenario.
     *
     * @var int|string|null
     */
    protected int|string|null $settingId = null;

    /**
     * Constructor for injecting form data and setting ID.
     *
     * @param array<string, mixed> $form
     * @param int|string|null $settingId
     */
    public function __construct(array $form = [], int|string|null $settingId = null)
    {
        parent::__construct();

        $this->form = $form;
        $this->settingId = $settingId;
    }

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
        $id = $this->settingId;
        return [
            'form.group' => 'required|string',
            'form.key' => 'required|string|max:255|unique:app_settings,key,' . $id . ',id',
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
