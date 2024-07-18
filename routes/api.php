<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Models\User;

 
Route:: get('users/{user}',[UserController::class, "show"])->name('api.users.show');

Route::get('users',[UserController::class,'index'])->name('api.users.index');

Route:: delete('users/{user}',[UserController::class, "destroy"])->name('api.users.delete');

Route::post('users', [UserController::class, 'store'])->name('api.users.store');

Route::put('users/{user}', [UserController::class, 'update'])->name('api.users.update');

Route::post('register',[AuthController::class,'store'])->name('api.users.store');

Route::post('login',[AuthController::class,'login'])->name('api.users.login');





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
