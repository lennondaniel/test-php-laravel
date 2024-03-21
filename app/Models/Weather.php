<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'weather';
    protected $fillable = [
        'city',
        'lat',
        'lon',
        'data_weather'
    ];
}
