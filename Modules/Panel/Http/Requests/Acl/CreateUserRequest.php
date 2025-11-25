<?php

namespace Modules\Panel\Http\Requests\Acl;

use Modules\Core\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Form data for user creation
     *
     * @var array<string, mixed>
     */
    public array $form = [];

    /**
     * Inject optional form data for manual validation or testing.
     *
     * @param array<string, mixed> $form
     */
    public function __construct(array $form = [])
    {
        parent::__construct();

        if (!empty($form)) {
            $this->form = $form;
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define validation rules for user creation.
     */
    public function rules(): array
    {
        $data = $this->form ?: $this->input('form', []);

        return [
            'form.name' => ['required', 'string', 'min:3'],
            'form.email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'form.email_verified' => ['boolean'],
            'form.password' => [
                'required',
                'confirmed',
                Password::min(8)
                // ->mixedCase()
                // ->numbers()
                // ->symbols()
                // ->uncompromised()
            ],
            'form.password_confirmation' => ['required', 'same:form.password'],
            'form.roles' => ['array'],
            'form.roles.*' => ['string', Rule::exists(Role::class, 'name')],
        ];
    }

    /**
     * Customize attribute names.
     */
    public function attributes(): array
    {
        return [
            'form.name' => 'name',
            'form.email' => 'email address',
            'form.email_verified' => 'email verification status',
            'form.password' => 'password',
            'form.password_confirmation' => 'password confirmation',
            'form.roles' => 'roles',
        ];
    }

    /**
     * Customize validation messages.
     */
    public function messages(): array
    {
        return [
            'form.name.required' => 'The :attribute is required.',
            'form.email.required' => 'The :attribute is required.',
            'form.email.email' => 'The :attribute must be a valid email address.',
            'form.email.unique' => 'This email is already taken.',
            'form.password.required' => 'The :attribute is required.',
            'form.password.min' => 'The :attribute must be at least :min characters.',
            'form.password.confirmed' => 'Passwords do not match.',
            'form.roles.*.exists' => 'One or more selected roles are invalid.',
        ];
    }
}