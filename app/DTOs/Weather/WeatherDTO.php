<?php

namespace App\DTOs\Weather;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use WendellAdriel\ValidatedDTO\Concerns\EmptyCasts;
use WendellAdriel\ValidatedDTO\Concerns\EmptyDefaults;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class WeatherDTO extends ValidatedDTO
{
    use EmptyDefaults, EmptyCasts;

    private string $city;
    private float $lat;
    private float $lon;
    private object $data_weather;

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            'city'     => ['required', 'string'],
            'lat'    => ['required'],
            'lon'    => ['required'],
            'data_weather' => ['required']
        ];
    }
}
