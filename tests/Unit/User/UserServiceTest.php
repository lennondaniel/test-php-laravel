<?php

namespace Tests\Unit\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserServiceTest extends TestCase
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
     * @return void
     * @throws Exception
     */
    public function test_create_user_service(): void
    {
        $user = User::factory()->make();
        $request = new Request();
        $request->merge([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);

        $userRepository = new UserRepository(new User());

        $userService = new UserService($userRepository);
        $userCreated = $userService->createUser($request);

        $this->assertInstanceOf(User::class, $userCreated);
        $this->assertEquals($request->input('name'), $userCreated->name);
        $this->assertEquals($request->input('email'), $userCreated->email);
    }

    /**
     * @throws Exception
     */
    public function test_login_service(): void
    {
        $password = '1234567';
        $user = User::factory()->create([
            'password' => $password
        ]);
        $request = new Request();
        $request->merge([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $password
        ]);

        $userRepository = new UserRepository(new User());

        $userService = new UserService($userRepository);

        $token = $userService->login($request);

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }
}
