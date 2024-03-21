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

    public string $city;
    public float $lat;
    public float $lon;
    public array $data_weather;

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
