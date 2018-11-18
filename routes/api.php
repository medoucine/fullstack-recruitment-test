<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// city API
Route::get('/city', 'Controller@getCities');
Route::get('/city/{city}/therapist', 'Controller@getTherapistsByCity');
Route::get('/city/{city}/practice/{practice}/therapist', 'Controller@getTherapistsByCityAndPractice');

// practice API
Route::get('/practice', 'Controller@getPracticies');
Route::get('/practice/{practice}/therapist', 'Controller@getTherapistsByPractice');
