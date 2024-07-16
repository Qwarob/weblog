<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home Route
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Articles Routes
Route::resource('articles', ArticleController::class);
Route::get('/my-articles', [ArticleController::class, 'myArticles'])->name('articles.my');

// Categories Routes
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Comments Routes
Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

// Auth Routes
Auth::routes();
