<?php

namespace App\Repositories\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email): User
    {
        return User::find([]);
    }

    /**
     * @param User $user
     * @return void
     */
    public function createUser(CreateUserDTO $user): void
    {
        $this->model->create($user->toArray());
    }
}
