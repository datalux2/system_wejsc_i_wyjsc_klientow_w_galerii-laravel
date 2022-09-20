<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/zlicz-losowo-wejscia-wyjscia', [CronController::class, 'count_random_input_output']);

Route::get('/wykres-statystyki', [StatisticsController::class, 'chart_statistics']);

Route::post('/pobierz-statystyki-wykresu-dzien', [StatisticsController::class, 'get_chart_statistics_by_day']);
