<?php

namespace Tests\Unit\User;

use App\DTOs\User\UserDTO;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\User\UserService;
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
}
