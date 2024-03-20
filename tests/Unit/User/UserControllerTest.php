<?php

namespace Tests\Unit\User;

use App\Http\Controllers\UserAuthController;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class UserControllerTest extends TestCase
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

    public function test_create_user_success(): void
    {
        $user = User::factory()->make();
        $request = new Request();
        $request->merge([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => $user['password']
        ]);
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userService = new UserService($userRepository);
        $userController = new UserAuthController($userService) ;
        $apiResponse = $userController->register($request);
        $apiContent = json_decode($apiResponse->getContent());

        $this->assertEquals(201, $apiResponse->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
        $this->assertEquals($request->input('name'), $apiContent->data->name);
        $this->assertEquals($request->input('email'), $apiContent->data->email);
    }

    public function test_create_user_error(): void
    {
        $user = User::factory()->make();
        $request = new Request();
        $request->merge([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'test'
        ]);
        $userModel = new User();
        $userRepository = new UserRepository($userModel);
        $userService = new UserService($userRepository);
        $userController = new UserAuthController($userService) ;
        $apiResponse = $userController->register($request);
        $apiContent = json_decode($apiResponse->getContent());

        $this->assertEquals(400, $apiResponse->getStatusCode());
        $this->assertEquals('error', $apiContent->status);
        $this->assertObjectHasProperty('message', $apiContent);
    }
}
