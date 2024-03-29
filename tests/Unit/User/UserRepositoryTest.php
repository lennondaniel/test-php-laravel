<?php

namespace Tests\Unit\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use WendellAdriel\ValidatedDTO\Exceptions\CastTargetException;
use WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException;

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
     * @throws CastTargetException
     * @throws MissingCastTypeException
     * @throws ValidationException
     */
    public function test_create_user_repository(): void
    {
        $user = User::factory()->make();
        $userDTO = new UserDTO([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);

        $userRepository = new UserRepository(new User());
        $userCreated = $userRepository->createUser($userDTO);

        $this->assertInstanceOf(User::class, $userCreated);
        $this->assertEquals($userDTO->name, $userCreated['name']);
        $this->assertEquals($userDTO->email, $userCreated['email']);
    }

    /**
     * @throws CastTargetException
     * @throws MissingCastTypeException
     * @throws ValidationException
     */
    public function test_create_token_repository(): void
    {
        $user = User::factory()->make();
        $userDTO = new UserDTO([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);

        $userRepository = new UserRepository(new User());
        $userCreated = $userRepository->createUser($userDTO);

        $token = $userRepository->createToken($userCreated);

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }


}
