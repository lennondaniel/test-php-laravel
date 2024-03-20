<?php

namespace App\Services\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface {

    private UserRepositoryInterface $userRespository;

    /**
     * Undocumented function
     *
     * @param UserRepository $userRepository
    */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRespository = $userRepository;
    }

    /**
     * Undocumented function
     *
     * @param UserDTO $userDTO
     * @return User
    */
    public function createUser(Request $request): User
    {
        try {
            $user = $request->all();
            $userDto = new UserDTO($user);
            return $this->userRespository->createUser($userDto);
        } catch (Exception $e) {
            throw new Exception('Failed create user: '. $e->getMessage());
        }
    }
    
}