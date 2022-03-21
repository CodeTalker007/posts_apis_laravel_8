<?php

use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\Auth\ForgetPasswordController;
use App\Http\Controllers\API\V1\Post\PostController;
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

Route::post('register', [AuthController::class, 'register'])->name('register')->name('register');
Route::get('verify-email/{token}', [AuthController::class, 'userActivate'])->name('verify.email-verification');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::prefix('forget-password')->name('forget-password.')->group(function () {
    Route::post('', [ForgetPasswordController::class, 'forget']);
    Route::get('{token}', [ForgetPasswordController::class, 'reset'])->name('reset');
    Route::post('confirm', [ForgetPasswordController::class, 'confirm']);
});
Route::group(['middleware' => ['auth:api']],function () {
    Route::prefix('posts')->name('post.')->group(function () {
        Route::post('/', [PostController::class, 'create'])->name('create');
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
    });
    Route::post('post/{post}/like', [\App\Http\Controllers\API\V1\Post\PostLikeController::class, 'likePost'])->name('like');
});
