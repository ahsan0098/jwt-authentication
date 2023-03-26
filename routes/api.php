<?php

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function ($routes) {
    Route::post('/register', [MainController::class, 'register'])->name('register');
    route::post('/login', [MainController::class, 'login']);
    route::post('/profile', [MainController::class, 'profile']);
    route::post('/logout', [MainController::class, 'logout']);
    route::post('/update', [MainController::class, 'update']);
});
