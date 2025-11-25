<?php

namespace Modules\Panel\Http\Requests\Acl;

use Modules\Core\Models\Role;
use Modules\Core\Models\Customer;
use Illuminate\Validation\Rule;
use Modules\Core\App\Enums\Guards;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Optional form data for service-layer or manual validation.
     *
     * @var array<string, mixed>
     */
    protected array $form = [];

    /**
     * Customer ID for the update scenario.
     *
     * @var string|null
     */
    protected string|null $customerId = null;

    /**
     * Constructor for injecting form data and customer ID.
     *
     * @param array<string, mixed> $form
     * @param string|null $customerId
     */
    public function __construct(array $form = [], string|null $customerId = null)
    {
        parent::__construct();

        $this->form = $form;
        $this->customerId = $customerId;
    }

    /**
     * Determine if the customer is authorized to make this request.
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
        $customerId = $this->customerId ?? $this->input('customer');

        return [
            'form.name' => ['required', 'string', 'min:3'],
            'form.email' => [
                'required',
                'email',
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'form.email_verified' => ['boolean'],
            'form.password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                // ->mixedCase()
                // ->numbers()
                // ->symbols()
                // ->uncompromised()
            ],
            'form.password_confirmation' => ['nullable', 'same:form.password'],
            'form.roles' => ['array'],
            'form.roles.*' => ['string', Rule::exists(Role::class, 'name')],
        ];
    }

    /**
     * Customize the attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'form.name' => 'customer name',
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
        ];
    }
}
