<?php

namespace Tests\Unit\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }
    /**
     * A basic test example.
     */
    public function test_create_find_user(): void
    {
        $userDTO = new CreateUserDTO([
            'name' => 'User test',
            'email' => 'user@tes.com', 
            'password' => 's3CreT!@1a2B'
        ]);

        $userRepository = new UserRepository(new User());
        $userRepository->createUser($userDTO);

        $userFind = $userRepository->findByEmail($userDTO->email);

        $this->assertEquals($userDTO->name, $userFind->name);
        $this->assertEquals($userDTO->email, $userFind->email);
    }
}
