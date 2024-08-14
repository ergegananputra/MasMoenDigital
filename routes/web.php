<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\SummernoteController;
use App\Http\Middleware\AdminPrivileges;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/beranda', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('articles', ArticlesController::class)->only('index', 'show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::prefix('kelola')->group(function () {
        Route::get('', [ManagementController::class, 'index'])->name('management.index');

        Route::name('management')->resource('articles', ArticlesController::class)->except('index, show');
        Route::post('/article/create/photos/upload', [SummernoteController::class, 'upload'])->name('summernote.upload');
        Route::post('articles/{article}/edit/photo/{photo_id}/destroy', [ArticlesController::class, 'destroyPhoto'])->name('management.articles.photos.destroy');
        Route::name('management')->resource('categories', CategoriesController::class)->middleware(AdminPrivileges::class);
    });



});
