<?php

namespace Tests\Unit\OpenWeather;

use App\Services\OpenWeather\OpenWeatherService;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class OpenWeatherServiceTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
    }
    /**
     * @throws GuzzleException
     */
    public function test_get_geocoding_by_city_is_success_service(): void
    {
        $httpClient = new Client();
        $service = new OpenWeatherService($httpClient);
        $response = $service->getGeocodingByCity('Curitiba');
        $this->assertIsArray($response);
    }

    /**
     * @throws Exception
     * @throws GuzzleException
     */
    public function test_get_weather_service(): void
    {
        $httpClient = new Client();
        $service = new OpenWeatherService($httpClient);
        $geocoding = $service->getGeocodingByCity('Curitiba');
        $response = $service->getWeatherByLogLat($geocoding[0]->lat, $geocoding[0]->lon);
        $this->assertObjectHasProperty('lat', $response);
        $this->assertObjectHasProperty('lon', $response);
    }

}

