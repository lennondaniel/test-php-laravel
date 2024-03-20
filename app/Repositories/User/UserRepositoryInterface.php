<?php

namespace App\Repositories\User;

use App\DTOs\User\LoginDTO;
use App\DTOs\User\UserDTO;
use App\Models\User;

interface UserRepositoryInterface {
    public function createUser(UserDTO $user): User;
    public function findByEmail(string $email): User;
    public function createToken(User $user): string;
}
