<?php

namespace App\Http\Requests;

use App\Rules\FullnameRule;
use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', new FullnameRule(), 'max:100'],
            'username' => ['required', new UsernameRule(), 'unique:users,username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ];
    }
}
