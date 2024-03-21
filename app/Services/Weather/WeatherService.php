<?php

namespace App\Services\Weather;

use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use App\Repositories\Weather\WeatherRepositoryInterface;
use App\Services\OpenWeather\OpenWeatherServiceInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class WeatherService implements WeatherServiceInterface
{
    private WeatherRepositoryInterface $weatherRepository;
    private OpenWeatherServiceInterface $openWeatherService;
    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        OpenWeatherServiceInterface $openWeatherService
    )
    {
        $this->weatherRepository = $weatherRepository;
        $this->openWeatherService = $openWeatherService;
    }

    /**
     * @param string $filter
     * @return Collection
     */
    public function getAll(string $filter = ''): Collection
    {
        return $this->weatherRepository->getAll($filter);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function createOrUpdate(string $city): Weather
    {
        try {
            $weather = $this->weatherRepository->findByCity($city);
            if (!is_null($weather)) {
                $savedDate = Carbon::parse($weather->updated_at);
                $now = Carbon::now();
                if ($now->diffInMinutes($savedDate) >= 30) {
                    $data = $this->getWeatherOpenWeather(true, '', $weather);
                    $weatherDTO = new WeatherDTO([
                        'city' => $weather->city,
                        'lat' => $weather->lat,
                        'lon' => $weather->lon,
                        'data_weather' => $data
                    ]);
                    $this->weatherRepository->update($weather->id, $weatherDTO);
                }
                return $weather;
            }

            $data = $this->getWeatherOpenWeather(false, $city, null);
            $weatherDTO = new WeatherDTO([
                'city' => $data['city'][0]->name,
                'lat' => $data['city'][0]->lat,
                'lon' => $data['city'][0]->lon,
                'data_weather' => $data['weather']
            ]);
            return $this->weatherRepository->create($weatherDTO);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param bool $isSaved
     * @param string $city
     * @param Weather|null $weather
     * @return array
     */
    public function getWeatherOpenWeather(
        bool $isSaved = false,
        string $city = '',
        Model $weather = null)
    : array
    {
        if(!$isSaved) {
            $cityData = $this->openWeatherService->getGeocodingByCity($city);
            $weatherData = $this->openWeatherService->getWeatherByLogLat(
                $cityData[0]->lat, $cityData[0]->lon
            );
            return [
                'city' => $cityData,
                'weather' => $weatherData
            ];
        }

        return $this->openWeatherService->getWeatherByLogLat(
            $weather['lat'], $weather['lon']
        );
    }

    /**
     * @param string $id
     * @return Weather
     */
    public function show(string $id): Weather
    {
        return $this->weatherRepository->show($id);
    }

    /**
     * @param Request $request
     * @return bool
     * @throws Exception
     */
    public function update(string $id, Request $request): bool
    {
        try {
            $weatherDTO = new WeatherDTO($request->toArray());
            return $this->weatherRepository->update($id, $weatherDTO);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        return $this->weatherRepository->delete($id);
    }
}
