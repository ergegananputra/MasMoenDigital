<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\SummernoteController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\AdminPrivileges;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

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
        Route::name('management')->resource('tags', TagsController::class)->middleware(AdminPrivileges::class);
        Route::name('management')->resource('users', UserManagementController::class)->middleware(AdminPrivileges::class);
        Route::put('users/{id}/promote', [UserManagementController::class, 'promote'])->name('management.users.promote');
        Route::put('users/{id}/demote', [UserManagementController::class, 'demote'])->name('management.users.demote');
    });



});

Route::get('/sitemap.xml', function () {
    if (!class_exists(Sitemap::class)) {
        return response('Sitemap class not found', 500);
    }
    
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/beranda'))
        ->add(Url::create('/articles'));

    // Add dynamic URLs for articles
    $articles = \App\Models\Article::all();
    foreach ($articles as $article) {
        $sitemap->add(Url::create("/articles/{$article->slug}"));
    }

    return response($sitemap->render(), 200)
        ->header('Content-Type', 'application/xml');
});
