<?php

namespace Modules\Panel\Http\Requests\Acl;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\App\Enums\Guards;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Optional custom form data (e.g. for service layer).
     *
     * @var array<string, mixed>
     */
    protected array $form = [];

    /**
     * ID of the permission being updated.
     *
     * @var int|string|null
     */
    protected int|string|null $permissionId = null;

    /**
     * Constructor for optional injection.
     *
     * @param array<string, mixed> $form
     * @param int|string|null $permissionId
     */
    public function __construct(array $form = [], int|string|null $permissionId = null)
    {
        parent::__construct();

        $this->form = $form;
        $this->permissionId = $permissionId;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define the validation rules.
     */
    public function rules(): array
    {
        $data = $this->form ?: $this->input('form', []);
        $guard = $data['guard_name'] ?? null;
        $permissionId = $this->permissionId ?? $this->input('permission');

        return [
            'form.name' => 'required|min:3|unique:permissions,name,' . $permissionId . ',id,guard_name,' . $guard,
            'form.guard_name' => 'required|in:' . implode(',', array_column(Guards::cases(), 'value')),
        ];
    }

    /**
     * Customize the attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'form.name' => 'permission name',
            'form.guard_name' => 'guard type',
        ];
    }

    /**
     * Customize validation messages.
     */
    public function messages(): array
    {
        return [
            'form.name.required'     => 'The :attribute is required.',
            'form.name.min'          => 'The :attribute must be at least :min characters.',
            'form.name.unique'       => 'This :attribute already exists.',
            'form.guard_name.required' => 'The :attribute is required.',
            'form.guard_name.in'     => 'The selected :attribute is invalid.',
        ];
    }
}
