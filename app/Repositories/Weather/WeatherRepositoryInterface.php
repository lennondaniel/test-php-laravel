<?php

namespace App\Repositories\Weather;

use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Collection;

interface WeatherRepositoryInterface
{
    public function getAll(string $filterCity = ''): Collection;
    public function create(WeatherDTO $weatherDTO): void;
    public function show(string $id): Weather;
    public function update(string $id, WeatherDTO $weatherDTO): void;
    public function delete(string $id): void;
}
