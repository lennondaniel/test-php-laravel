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
            return new JsonResponse(
                $user,
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return new JsonResponse(
                [
                    'message' => $e->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

    }
}
