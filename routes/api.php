<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{LoginController, RegisterController, LogoutController};
use App\Http\Controllers\{UserController, PostController};

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Auth
Route::post('login', LoginController::class);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', LogoutController::class);

Route::get('/user', UserController::class)->middleware(['auth:sanctum']);

//Post Route
Route::get('/posts', [PostController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/post/store', [PostController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/post/{id}', [PostController::class, 'edit'])->middleware(['auth:sanctum']);
Route::put('/post/update/{post:id}', [PostController::class, 'update'])->middleware(['auth:sanctum']);