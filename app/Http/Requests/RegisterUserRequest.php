<?php

namespace App\Http\Requests;

use App\Rules\FullnameRule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

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
            "name" => ["required", new FullnameRule(), "max:100"],
            "username" => ["required", "alpha_num:ascii", "min:3", "max:100"],
            "email" => ['required', 'string', 'lowercase', 'email', 'unique:users,email'],
            "password" => ['required', Password::defaults()]
        ];
    }
}
