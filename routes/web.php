<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\BookController as FrontBookController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('front.home');

Route::prefix('catalog')
    ->name('front.books.')
    ->group(function (): void {
        Route::get('/', [FrontBookController::class, 'index'])->name('index');
        Route::get('/{book}', [FrontBookController::class, 'show'])->name('show');
    });

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('books', BookController::class)->except(['show']);
});

require __DIR__.'/auth.php';
