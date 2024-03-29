<?php

namespace App\Repositories\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;

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
        return $this->model->where('email', $email)->first();
    }

    /**
     * @param User $user
     * @return User
     */
    public function createUser(UserDTO $user): User
    {
        return $this->model->create($user->toArray());
    }

    /**
     * @param User $user
     * @return string
     */
    public function createToken(Authenticatable $user): string
    {
        return $user->createToken('api_token')->plainTextToken;
    }
}
