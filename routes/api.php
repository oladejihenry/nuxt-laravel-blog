<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\{LoginController, RegisterController, LogoutController};
use App\Http\Controllers\{UserController, PostController, CategoryController, FrontEndController};

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
Route::get('/post/bin', [PostController::class, 'trashed'])->middleware(['auth:sanctum']);
Route::get('/post/{id}', [PostController::class, 'edit'])->middleware(['auth:sanctum']);
Route::put('/post/update/{post:id}', [PostController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/post/delete/{post:id}', [PostController::class, 'destroy'])->middleware(['auth:sanctum']);
Route::put('/post/restore/{post:id}', [PostController::class, 'restore'])->middleware(['auth:sanctum']);
Route::delete('/post/forceDelete/{post:id}', [PostController::class, 'forceDelete'])->middleware(['auth:sanctum']);


//Category Route
Route::get('/categories', [CategoryController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/category/store', [CategoryController::class, 'store'])->middleware(['auth:sanctum']);
Route::get('/category/{id}', [CategoryController::class, 'edit'])->middleware(['auth:sanctum']);
Route::put('/category/update/{category:id}', [CategoryController::class, 'update'])->middleware(['auth:sanctum']);

//Frontend Route
Route::get('/frontpage', [FrontEndController::class, 'index']);