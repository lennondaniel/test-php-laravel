<?php

namespace Tests\Unit\Weather;

use App\DTOs\Weather\WeatherDTO;
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

class WeatherServiceTest extends TestCase
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
    function test_get_all_weather_service()
    {
        Weather::factory(3)->create();
        $request = Request::create('https://test.com');
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weathers = $weatherService->getAll($request);

        $this->assertInstanceOf(Collection::class, $weathers);
        $this->assertEquals(3, $weathers->count());
    }

    /**
     * @return void
     */
    function test_get_all_with_filter_weather_service()
    {
        $weatherFactory = Weather::factory(3)->create();
        $weatherFactoryArray = $weatherFactory->toArray();
        $request = Request::create('https://test.com?filter='. $weatherFactoryArray[0]['city']);

        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weathers = $weatherService->getAll($request);

        $this->assertInstanceOf(Collection::class, $weathers);
        $this->assertEquals(1, $weathers->count());
    }

    /**
     * @return void
     */
    function test_show_weather_service()
    {
        $weatherFactory = Weather::factory()->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weather = $weatherService->show($weatherFactory->id);

        $this->assertInstanceOf(Weather::class, $weather);
        $this->assertEquals($weatherFactory->id, $weather['id']);
    }

    /**
     * @return void
     * @throws Exception
     */
    function test_update_weather_service()
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
        $weather = $weatherService->update($weatherFactory->id, $request);

        $this->assertTrue($weather);
    }

    /**
     * @return void
     * @throws Exception
     */
    function test_delete_weather_service()
    {
        $weatherFactory = Weather::factory()->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weather = $weatherService->delete($weatherFactory->id);

        $this->assertTrue($weather);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_create_or_update_new_weather_service(): void
    {
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherCreated = $weatherService->createOrUpdate('Curitiba');

        $this->assertInstanceOf(Weather::class, $weatherCreated);
        $this->assertIsString($weatherCreated['city']);
    }

    /**
     * @return void
     */
    public function test_create_or_update_less_than_30_minutes_weather_service(): void
    {
        $weatherFactory = Weather::factory([
             'city' => 'Curitiba'
        ])->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $openWeatherService = new OpenWeatherService(new Client());

        $weatherService = new WeatherService($weatherRepository, $openWeatherService);
        $weatherUpdateD = $weatherService->createOrUpdate('Curitiba');

        $this->assertInstanceOf(Weather::class, $weatherUpdateD);
        $this->assertEquals($weatherUpdateD['id'], $weatherFactory['id']);
    }

}
