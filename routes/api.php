<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Публічні контролери
use App\Http\Controllers\Api\Blog\PostController;
use App\Http\Controllers\DiggingDeeperController;

use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController;

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
    // BlogCategory (Лабораторні 4-18) - РОЗБЛОКОВАНО ВСІ МЕТОДИ
    Route::apiResource('categories', CategoryController::class)
        ->names('blog.admin.categories');

    // BlogPost Лабораторна 8-18
    Route::apiResource('posts', AdminPostController::class)
        ->names('blog.admin.posts');

});

Route::group(['prefix' => 'digging_deeper'], function () {
    Route::get('process-video', [\App\Http\Controllers\DiggingDeeperController::class, 'processVideo'])
        ->name('digging_deeper.processVideo');

    Route::get('prepare-catalog', [\App\Http\Controllers\DiggingDeeperController::class, 'prepareCatalog'])
        ->name('digging_deeper.prepareCatalog');
});
