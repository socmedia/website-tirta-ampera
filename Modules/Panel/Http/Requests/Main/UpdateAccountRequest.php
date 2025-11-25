<?php

namespace Modules\Panel\Http\Requests\Main;

use Modules\Core\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|unique:users,email,' . $this->user->id,
            'form.avatar' => 'nullable|string',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'form.name' => 'name',
            'form.email' => 'email',
            'form.avatar' => 'avatar',
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
