<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\MailController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Post
Route::post('post', [PostController::class, 'post']);
Route::get('viewpost', [PostController::class, 'viewpost']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('sendmail', [MailController::class, 'sendmail'])->name('email');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
