<?php

namespace App\Repositories\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User;

interface UserRepositoryInterface {
    public function createUser(CreateUserDTO $user): void;
}
