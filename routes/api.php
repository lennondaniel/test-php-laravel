<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/register', [UserAuthController::class, 'register'])->name('api-register');
Route::post('/users/login', [UserAuthController::class, 'login'])->name('api-login');
Route::middleware('auth:sanctum')->get(
    '/admin/weather', [WeatherController::class, 'index']
)->name('getAllWeather');
Route::middleware('auth:sanctum')->get(
    '/weather/{city}', [WeatherController::class, 'getWeatherByCity']
)->name('getWeatherByCity');
Route::middleware('auth:sanctum')->get(
    '/admin/weather/{id}', [WeatherController::class, 'show']
)->name('findByIdWeather');
Route::middleware('auth:sanctum')->put(
    '/admin/weather/{id}', [WeatherController::class, 'update']
)->name('updateWeather');
Route::middleware('auth:sanctum')->delete(
    '/admin/weather/{id}', [WeatherController::class, 'delete']
)->name('deleteWeather');
