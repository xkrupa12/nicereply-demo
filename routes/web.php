<?php

use App\Http\Controllers\NiceReply\RatingsController;
use App\Http\Controllers\NiceReply\SurveysController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->to('/surveys');
});

Route::get('surveys', [SurveysController::class, 'index']);
Route::get('surveys/{survey_id}/ratings', [RatingsController::class, 'index']);
Route::post('surveys/{survey_id}/ratings', [RatingsController::class, 'store']);
Route::get('surveys/{survey_id}/ratings/create', [RatingsController::class, 'create']);

