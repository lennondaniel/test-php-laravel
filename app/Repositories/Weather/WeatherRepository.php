<?php

namespace App\Repositories\Weather;


use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Collection;

class WeatherRepository implements WeatherRepositoryInterface
{
    private Weather $model;

    public function __construct(Weather $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $filterCity
     * @return Collection
     */
    public function getAll(string $filterCity = ''): Collection
    {
        if(empty($filterCity)){
            return $this->model->all();
        }

        return $this->model->where('city', $filterCity);
    }

    /**
     * @param WeatherDTO $weatherDTO
     * @return void
     */
    public function create(WeatherDTO $weatherDTO): void
    {
        $this->model->create($weatherDTO->toArray());
    }

    /**
     * @param string $id
     * @return Weather
     */
    public function show(string $id): Weather
    {
        return $this->model->find($id);
    }

    /**
     * @param string $id
     * @param WeatherDTO $weatherDTO
     * @return void
     */
    public function update(string $id, WeatherDTO $weatherDTO): void
    {
        $weatherArray = $weatherDTO->toArray();
        $weather = $this->model->find($id);
        $weather->city = $weatherArray['city'];
        $weather->lat = $weatherArray['lat'];
        $weather->lon = $weatherArray['lon'];
        $weather->data_weather = $weatherArray['data_weather'];

        $weather->save();
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        $this->model->destroy($id);
    }
}
