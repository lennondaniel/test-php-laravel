<?php

namespace App\Services\OpenWeather;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class OpenWeatherService implements OpenWeatherServiceInterface
{

    private string $openWeatherApiKey;
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->openWeatherApiKey = config('app.openWeatherApiKey');
    }

    /**
     * @param string $city
     * @return mixed
     * @throws GuzzleException
     * @throws Exception
     */
    public function getGeocodingByCity(string $city): mixed
    {
        try {
            $response = $this->client->get(
                'http://api.openweathermap.org/geo/1.0/direct?q='
                . $city . '&limit=1&appid=' . $this->openWeatherApiKey
            );
            $content = json_decode($response->getBody()->getContents());
            if(!empty($content)) {
                return $content;
            }
            throw new Exception('Geocoding not found');
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param float $lat
     * @param float $lon
     * @return mixed
     * @throws Exception
     */
    public function getWeatherByLogLat(float $lat, float $lon): mixed
    {
        try {
            $response = $this->client->get(
                'https://api.openweathermap.org/data/3.0/onecall?lat='
                . $lat . '&lon='.$lon .'&lang=pt_br&units=metric&exclude=minutely,hourly&appid='
                . $this->openWeatherApiKey
            );
            $content = json_decode($response->getBody()->getContents());
            if(!empty($content)) {
                return $content;
            }
            throw new Exception('Weather not found');
        } catch (GuzzleException $e) {
            throw new Exception($e);
        }
    }
}
