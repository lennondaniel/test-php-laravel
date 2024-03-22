<?php

namespace Tests\Unit\Weather;

use App\DTOs\Weather\WeatherDTO;
use App\Http\Controllers\WeatherController;
use App\Models\Weather;
use App\Repositories\Weather\WeatherRepository;
use App\Repositories\Weather\WeatherRepositoryInterface;
use App\Services\OpenWeather\OpenWeatherService;
use App\Services\Weather\WeatherService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @return void
     */
    function test_index_weather_controller()
    {
        Weather::factory(3)->create();
        $request = Request::create('https://test.com');
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->index($request);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

    /**
     * @return void
     */
    function test_index_with_filter_weather_controller()
    {
        $weatherFactory = Weather::factory(3)->create();
        $weatherArray = $weatherFactory->toArray();
        $request = Request::create('https://test.com?filter='.$weatherArray[0]['city']);
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->index($request);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

    /**
     * @return void
     */
    function test_show_weather_controller()
    {
        $weatherFactory = Weather::factory()->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->show($weatherFactory->id);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
        $this->assertEquals($weatherFactory->id, $apiContent->data->id);
    }

    /**
     * @return void
     * @throws Exception
     */
    function test_update_weather_controller()
    {
        $weatherFactory = Weather::factory()->create();
        $request = new Request();
        $request->merge([
            'city' => $weatherFactory->city,
            'lat' => $weatherFactory->lat,
            'lon' => $weatherFactory->lon,
            'data_weather' => $weatherFactory->data_weather
        ]);
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->update($weatherFactory->id, $request);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

    /**
     * @return void
     * @throws Exception
     */
    function test_delete_weather_controller()
    {
        $weatherFactory = Weather::factory()->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->delete($weatherFactory->id);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_findWeather_new_weather_controller(): void
    {
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->searchWeather('Curitiba');
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

    /**
     * @return void
     */
    public function test_search_weather_created_weather_controller(): void
    {
        $weatherFactory = Weather::factory([
            'city' => 'Curitiba'
        ])->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());
        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherController = new WeatherController($weatherService);
        $response = $weatherController->searchWeather($weatherFactory->city);
        $apiContent = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('success', $apiContent->status);
    }

}
