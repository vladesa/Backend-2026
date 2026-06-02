<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Публічні контролери
use App\Http\Controllers\Api\Blog\PostController;


use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController; // <--- Використовуємо псевдонім!

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'blog'], function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});

// Адмінка
$groupData = [
    'namespace' => 'App\Http\Controllers\Api\Blog\Admin',
    'prefix' => 'admin/blog',
];

Route::group($groupData, function () {
    // BlogCategory (Лабораторні 4-7)
    $methods = ['index', 'store', 'update'];
    Route::apiResource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');

    // BlogPost (Лабораторна 8 - ДОДАНО)
    Route::apiResource('posts', AdminPostController::class)
        ->except(['show'])
        ->names('blog.admin.posts');
});
