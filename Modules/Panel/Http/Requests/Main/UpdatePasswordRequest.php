<?php

namespace Modules\Panel\Http\Requests\Main;

use Modules\Core\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * The user model instance.
     *
     * @var \Modules\Core\Models\User
     */
    public User $user;

    /**
     * Class constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'form.current_password' => ['required', 'current_password:web'],
            'form.password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.current_password' => 'current password',
            'form.password' => 'new password',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
