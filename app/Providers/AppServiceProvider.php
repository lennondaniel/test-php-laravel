<?php

namespace App\Providers;

use App\Repositories\Weather\WeatherRepository;
use App\Repositories\Weather\WeatherRepositoryInterface;
use App\Services\OpenWeather\OpenWeatherService;
use App\Services\OpenWeather\OpenWeatherServiceInterface;
use App\Services\Weather\WeatherService;
use App\Services\Weather\WeatherServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OpenWeatherServiceInterface::class, OpenWeatherService::class);
        $this->app->bind(WeatherRepositoryInterface::class, WeatherRepository::class);
        $this->app->bind(WeatherServiceInterface::class, WeatherService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
