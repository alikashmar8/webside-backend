<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\ProjectController;

=======
use App\Http\Controllers\EmailSubscriberController;
use App\Http\Controllers\ProjectController;


>>>>>>> f6c5dfef11497804d26084a0b7076cfa2d899b63
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

<<<<<<< HEAD
Route::group([
    'middleware' => 'api',
=======

Route::group([
>>>>>>> f6c5dfef11497804d26084a0b7076cfa2d899b63
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
<<<<<<< HEAD
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api'
], function ($router){
    Route::resource( 'projects' , ProjectController::class);

=======
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.verify');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('jwt.verify');
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('jwt.verify');
});




Route::group([
    'prefix' => 'projects'
], function ($router) {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{project}', [ProjectController::class, 'show']);
    Route::post('/', [ProjectController::class, 'store'])->middleware('jwt.verify');
    Route::put('/', [ProjectController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->middleware('jwt.verify');
});

Route::group([
    'prefix' => 'email-subscribers'
], function ($router) {
    Route::get('/', [EmailSubscriberController::class, 'index'])->middleware('jwt.verify');
    Route::get('/{emailSubscriber}', [EmailSubscriberController::class, 'show'])->middleware('jwt.verify');;
    Route::post('/', [EmailSubscriberController::class, 'store']);
    Route::put('/', [EmailSubscriberController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{emailSubscriber}', [EmailSubscriberController::class, 'destroy'])->middleware('jwt.verify');
>>>>>>> f6c5dfef11497804d26084a0b7076cfa2d899b63
});
