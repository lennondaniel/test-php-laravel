<?php

namespace App\Repositories\Weather;


use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Collection as CollectionSupport;

class WeatherRepository implements WeatherRepositoryInterface
{
    private Weather $model;
    private QueryBuilder $query;

    public function __construct(Weather $model)
    {
        $this->model = $model;
        $this->query = DB::table('weather');
    }

    /**
     * @param string $filterCity
     * @return Collection|Builder
     */
    public function getAll(string $filterCity = ''): Collection|Builder
    {
        if(empty($filterCity)){
            return $this->model->all();
        }

        return $this->model->where('city', strtolower($filterCity))->get();
    }

    /**
     * @param string $city
     * @return Model|null
     */
    public function findByCity(string $city): Model|null
    {
        return $this->model->where('city', strtolower($city))->first();
    }

    /**
     * @param WeatherDTO $weatherDTO
     * @return Weather
     */
    public function create(WeatherDTO $weatherDTO): Weather
    {
        return $this->model->create($weatherDTO->toArray());
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
     * @return bool
     */
    public function update(string $id, WeatherDTO $weatherDTO): bool
    {
        $weatherArray = $weatherDTO->toArray();
        $weather = $this->model->find($id);
        $weather->city = $weatherArray['city'];
        $weather->lat = $weatherArray['lat'];
        $weather->lon = $weatherArray['lon'];
        $weather->data_weather = $weatherArray['data_weather'];

        return $weather->save();
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->model->destroy($id);
    }
}
