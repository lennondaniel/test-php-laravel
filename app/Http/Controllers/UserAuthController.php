<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiSuccessResource;
use App\Http\Responses\ApiErrorResource;
use App\Services\User\UserServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserAuthController extends Controller
{
    private UserServiceInterface $userService;
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    public function register(Request $request)
    {
        try {
            $user = $this->userService->createUser($request);
            $statusCode = Response::HTTP_CREATED;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => $user
                ],
                $statusCode
            );
        } catch (Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            return new JsonResponse(
                [
                    'status' => 'error',
                    'code' => $statusCode,
                    'message' => $e->getMessage()
                ],
                $statusCode
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $token = $this->userService->login($request);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => [
                        'token' => $token
                    ]
                ],
                $statusCode
            );
        } catch (Exception $e) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
            return new JsonResponse(
                [
                    'status' => 'error',
                    'code' => $statusCode,
                    'message' => $e->getMessage()
                ],
                $statusCode
            );
        }
    }

}
