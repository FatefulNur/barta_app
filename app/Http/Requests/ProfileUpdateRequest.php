<?php

namespace App\Http\Requests;

use App\Rules\FullnameRule;
use App\Rules\UsernameRule;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'avatar' => ['sometimes', File::image()->max('5mb')],
            'name' => ['required', new FullnameRule(), 'max:100'],
            'username' => ['required', new UsernameRule(), "unique:users,username,{$this->user()->id}"],
            'email' => ['required', 'email', "unique:users,email,{$this->user()->id}"],
            'password' => ['nullable', Password::default()],
            'bio' => ['nullable', 'string'],
        ];
    }
}
