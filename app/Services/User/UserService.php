<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface {

    private UserRepositoryInterface $userRepository;

    /**
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return User
     * @throws Exception
     */
    public function createUser(Request $request): User
    {
        $user = $request->all();
        $userDto = new UserDTO($user);
        return $this->userRepository->createUser($userDto);
    }
}
