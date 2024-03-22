<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use App\Services\Weather\WeatherServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    private WeatherServiceInterface $weatherService;

    public function __construct(WeatherServiceInterface $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $weathers = $this->weatherService->getAll($request);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => $weathers
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
     * @param string $city
     * @return JsonResponse
     */
    public function searchWeather(string $city): JsonResponse
    {
        try {
            $weather = $this->weatherService->createOrUpdate($city);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => $weather
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
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $weather = $this->weatherService->show($id);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => $weather
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
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $this->weatherService->update($id, $request);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => [
                        'message' => 'Weather updated successfully'
                    ]
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
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        try {
            $this->weatherService->delete($id);
            $statusCode = Response::HTTP_OK;
            return new JsonResponse(
                [
                    'status' => 'success',
                    'code' => $statusCode,
                    'data' => [
                        'message' => 'Weather deleted successfully'
                    ]
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
}
