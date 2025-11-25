<?php

namespace Modules\Panel\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    /**
     * Optional form data for service-layer or manual validation.
     *
     * @var array<string, mixed>
     */
    protected array $form = [];

    /**
     * Content ID for the update scenario.
     *
     * @var int|string|null
     */
    protected int|string|null $contentId = null;

    /**
     * Constructor for injecting form data and content ID.
     *
     * @param array<string, mixed> $form
     * @param int|string|null $contentId
     */
    public function __construct(array $form = [], int|string|null $contentId = null)
    {
        parent::__construct();

        $this->form = $form;
        $this->contentId = $contentId;
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
        return [
            'form.page' => 'required|max:255',
            'form.section' => 'nullable|max:255',
            'form.key' => 'required|max:255|unique:contents,key,' . $this->contentId . ',id',
            'form.type' => 'required|max:50',
            'form.meta' => 'nullable',
            'form.name' => 'required|max:255',
            'form.value' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.page' => 'page',
            'form.section' => 'section',
            'form.key' => 'key',
            'form.type' => 'type',
            'form.meta' => 'meta',
            'form.name' => 'translation name',
            'form.value' => 'translation value',
        ];
    }
}
