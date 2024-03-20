<?php

namespace App\Repositories\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

interface UserRepositoryInterface {
    public function createUser(UserDTO $user): User;
    public function findByEmail(string $email): User;
    public function createToken(Authenticatable $user): string;
}
