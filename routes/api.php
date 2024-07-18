<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\CategoryController;

Route::get('user/{user}', [UserController::class, 'show'])->name('api.users.show');

Route::get('users', [UserController::class,'index'])->name('api.users.index');

Route::delete('user/{user}', [UserController::class,'destroy'])->name('api.users.delete');

Route::post('users', [UserController::class, 'store'])->name('api.users.store');

Route::put('users/{user}', [UserController::class, 'update'])->name('api.users.update');

Route::post('register',[AuthController::class,'store'])->name('api.users.store');

Route::post('login',[AuthController::class,'login'])->name('api.users.login');

Route::get('posts', [PostController::class, 'index'])->name('api.posts.index');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts/{post}', [PostController::class, 'show'])->name('api.posts.show');
    Route::post('posts', [PostController::class, 'store'])->name('api.posts.store');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('api.posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('api.posts.delete');
   // Route::get('posts', [PostController::class, 'myPosts'])->name('api.posts.myPosts');
    Route::get('my-posts', [PostController::class, 'myPosts'])->name('api.posts.myPosts'); 
});
//

// Route::get('videos/{video}',[VideoController::class, 'show'])->name('api.videos.show');

// Route::get('videos',[VideoController::class,'index'])->name('api.videos.index');

// Route::post('videos', [VideoController::class, 'store'])->name('api.videos.store');

// Route::put('videos/{video}', [VideoController::class, 'update'])->name('api.videos.update');

// Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('api.videos.destroy');

//

Route::get('categories/{category}',[CategoryController::class, 'show'])->name('api.categories.show');

Route::get('categories',[CategoryController::class,'index'])->name('api.categories.index');




