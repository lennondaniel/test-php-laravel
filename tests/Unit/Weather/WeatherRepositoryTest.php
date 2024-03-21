<?php

namespace Tests\Unit\Weather;

use App\DTOs\User\UserDTO;
use App\DTOs\Weather\WeatherDTO;
use App\Models\Weather;
use App\Repositories\User\UserRepository;
use App\Repositories\Weather\WeatherRepository;
use Database\Factories\WeatherFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use WendellAdriel\ValidatedDTO\Exceptions\CastTargetException;
use WendellAdriel\ValidatedDTO\Exceptions\MissingCastTypeException;
use Illuminate\Support\Collection as SupportCollection;

class WeatherRepositoryTest extends TestCase
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
    public function test_get_all_weather_repository(): void
    {
        $weatherFactory = Weather::factory(3)->create();

        $weatherRepository = new WeatherRepository(new Weather());
        $weathers = $weatherRepository->getAll();

        $this->assertInstanceOf(Collection::class, $weathers);
        $this->assertEquals(3, $weathers->count());
    }

    /**
     * @return void
     */
    public function test_get_all_with_filter_city_weather_repository(): void
    {
        $weatherFactory = Weather::factory(3)->create();
        $weatherArray = $weatherFactory->toArray();
        $weatherRepository = new WeatherRepository(new Weather());
        $weathers = $weatherRepository->getAll($weatherArray[0]['city']);
        $this->assertInstanceOf(SupportCollection::class, $weathers);
        $this->assertEquals(1, $weathers->count());
    }

    public function test_find_weather_by_city_weather_repository(): void
    {
        $weatherFactory = Weather::factory(3)->create();
        $weatherArray = $weatherFactory->toArray();
        $weatherRepository = new WeatherRepository(new Weather());
        $weather = $weatherRepository->findByCity($weatherArray[0]['city']);
        $this->assertInstanceOf(Weather::class, $weather);
        $this->assertEquals($weatherArray[0]['city'], $weather['city']);
    }

    /**
     * @return void
     * @throws CastTargetException
     * @throws MissingCastTypeException
     * @throws ValidationException
     */
    public function test_create_weather_repository(): void
    {
        $weather = Weather::factory()->make();
        $weatherDTO = new WeatherDTO($weather->toArray());

        $weatherRepository = new WeatherRepository(new Weather());
        $weatherCreated = $weatherRepository->create($weatherDTO);

        $this->assertInstanceOf(Weather::class, $weatherCreated);
        $this->assertEquals($weatherDTO->city, $weatherCreated['city']);
    }

    /**
     * @return void
     */
    public function test_show_weather_repository(): void
    {
        $weatherFactory = Weather::factory(3)->create();
        $weatherArray = $weatherFactory->toArray();
        $weatherRepository = new WeatherRepository(new Weather());
        $weather = $weatherRepository->show($weatherArray[0]['id']);
        $weatherCollect = $weather->toArray();

        $this->assertInstanceOf(Weather::class, $weather);
        $this->assertEquals($weatherArray[0]['id'], $weatherCollect['id']);
    }

    /**
     * @throws CastTargetException
     * @throws MissingCastTypeException
     * @throws ValidationException
     */
    public function test_update_success_weather_repository(): void
    {
        $weatherFactory = Weather::factory()->create();
        $weatherDTO = new WeatherDTO($weatherFactory->toArray());
        $weatherRepository = new WeatherRepository(new Weather());
        $weather = $weatherRepository->update($weatherFactory['id'], $weatherDTO);

        $this->assertTrue($weather);
    }

    /**
     * @return void
     */
    public function test_delete_weather_repository(): void
    {
        $weatherFactory = Weather::factory()->create();
        $weatherRepository = new WeatherRepository(new Weather());
        $weather = $weatherRepository->delete($weatherFactory['id']);

        $this->assertTrue($weather);
    }
}
