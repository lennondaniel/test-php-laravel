<?php

namespace App\Services\OpenWeather;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface OpenWeatherServiceInterface
{
    public function getGeocodingByCity(string $city): mixed;
    public function getWeatherByLogLat(float $lat, float $lon);
}
