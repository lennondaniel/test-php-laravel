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

    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
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
