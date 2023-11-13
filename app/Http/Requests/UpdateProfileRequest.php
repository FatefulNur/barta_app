<?php

namespace App\Http\Requests;

use App\Rules\FullnameRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            "email" => ["required", "email", "unique:users,email,{$this->user()->id}"],
            "password" => ["nullable", "string", "min:6", "max:20"],
            "bio" => ["nullable", "string"]
        ];
    }
}
