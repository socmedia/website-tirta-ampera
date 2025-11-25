<?php

namespace Modules\Panel\Http\Requests\Acl;

use Modules\Core\Models\Role;
use Modules\Core\App\Enums\Guards;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Optional form data for service-layer or manual validation.
     *
     * @var array<string, mixed>
     */
    protected array $form = [];

    /**
     * Role ID for the update scenario.
     *
     * @var int|string|null
     */
    protected int|string|null $roleId = null;

    /**
     * Constructor for injecting form data and role ID.
     *
     * @param array<string, mixed> $form
     * @param int|string|null $roleId
     */
    public function __construct(array $form = [], int|string|null $roleId = null)
    {
        parent::__construct();

        $this->form = $form;
        $this->roleId = $roleId;
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
        $roleId = $this->roleId ?? $this->input('role');

        return [
            'form.name' => [
                'required',
                'min:3',
                function ($attribute, $value, $fail) use ($data, $roleId) {
                    $guardName = $data['guard_name'] ?? null;

                    if (!$guardName) {
                        return $fail("Guard type must be selected.");
                    }

                    $exists = Role::where('name', $value)
                        ->where('guard_name', $guardName)
                        ->where('id', '!=', $roleId)
                        ->exists();

                    if ($exists) {
                        $fail("A role with this name already exists for the selected guard.");
                    }
                }
            ],
            'form.guard_name' => 'required|in:' . implode(',', array_column(Guards::cases(), 'value')),
        ];
    }

    /**
     * Customize the attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'form.name' => 'role name',
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
            'form.guard_name.required' => 'The :attribute is required.',
            'form.guard_name.in'     => 'The selected :attribute is invalid.',
        ];
    }
}
