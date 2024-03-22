<?php

namespace App\Services\Weather;



use App\Models\Weather;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;


interface WeatherServiceInterface
{
    public function getAll(Request $request): Collection;
    public function createOrUpdate(string $city): Weather;
    public function getWeatherOpenWeather(
        bool $isSaved = false,
        string $city = '',
        Model $weather = null
    ): array;
    public function show(string $id): Weather;
    public function update(string $id, Request $request): bool;
    public function delete(string $id): bool;
}
