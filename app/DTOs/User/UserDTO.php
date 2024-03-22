<?php

namespace App\DTOs\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\Concerns\EmptyDefaults;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class UserDTO extends ValidatedDTO
{
    use EmptyCasts, EmptyDefaults;

    public string $name;
    public string $email;
    public string $password;

    protected function rules(): array
    {
        return [
            'name'     => ['required', 'string'],
            'email'    => ['required', 'email'],
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];
    }
}
