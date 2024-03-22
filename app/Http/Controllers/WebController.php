<?php

namespace App\Http\Controllers;

use App\Services\Weather\WeatherServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class WebController extends Controller
{
    private WeatherServiceInterface $weatherService;

    public function __construct(WeatherServiceInterface $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $weathers = $this->weatherService->getAll($request);
            return Inertia::render('Weathers', ['weathers' => $weathers->toArray()]);
        } catch (Exception $e) {
            return Inertia::render('Errors', ['errors' => $e->getMessage()]);
        }
    }

    /**
     * @param string $city
     * @return \Inertia\Response
     */
    public function dashboard(string $city): \Inertia\Response
    {
        try {
            $weather = $this->weatherService->createOrUpdate($city);
            return Inertia::render('Dashboard', ['weather' => $weather->toArray()]);
        } catch (Exception $e) {
            return Inertia::render('Errors', ['errors' => $e->getMessage()]);
        }
    }
}
