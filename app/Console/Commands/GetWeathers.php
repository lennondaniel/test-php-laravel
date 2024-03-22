<?php

namespace App\Console\Commands;

use App\Models\Weather;
use App\Repositories\Weather\WeatherRepository;
use App\Services\OpenWeather\OpenWeatherService;
use App\Services\Weather\WeatherService;
use App\Services\Weather\WeatherServiceInterface;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetWeathers extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-weathers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca por uma determinada quantidade de temperaturas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $cities = ['Curitiba', 'Rio de Janeiro', 'Maringa',
                'Cianorte', 'São Paulo', 'Pinhais', 'Colombo', 'Salvador', 'Cruz Alta', 'Cambé'];

            $client = new Client();
            $model = new Weather();
            $weatherRepository = new WeatherRepository($model);
            $openWeatherService = new OpenWeatherService($client);
            $service = new WeatherService($weatherRepository, $openWeatherService);

            foreach ($cities as $value) {
                $service->createOrUpdate($value);
            }
        }catch (\Exception $e) {
            throw new \Exception('Not found command get weathers');
        }

    }
}
