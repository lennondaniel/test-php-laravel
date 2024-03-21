<?php

namespace App\Repositories\Weather;

use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


interface WeatherRepositoryInterface
{
    public function getAll(string $filterCity = ''): Collection|Builder;
    public function findByCity(string $city): Model|null;
    public function create(WeatherDTO $weatherDTO): Weather;
    public function show(string $id): Weather;
    public function update(string $id, WeatherDTO $weatherDTO): bool;
    public function delete(string $id): bool;
}
