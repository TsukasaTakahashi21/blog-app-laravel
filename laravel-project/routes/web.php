<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FavoriteController;

// User
Route::get('/', [UserController::class, 'signUp'])->name('signUp');
Route::get('/login', [UserController::class, 'signIn'])->name('signIn');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [BlogController::class, 'logout'])->name('logout');

// blog
Route::get('/top', [BlogController::class, 'filterBlogs'])->name('top');
Route::get('/mypage', [BlogController::class, 'myPage'])->name('mypage');

Route::get('/create', [BlogController::class, 'create'])->name('create');
Route::post('/store', [BlogController::class, 'store'])->name('store');

Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [BlogController::class, 'update'])->name('update');

Route::get('/detail/{id}', [BlogController::class, 'detail'])->name('detail');
Route::post('/comment/{id}', [BlogController::class, 'storeComment'])->name('storeComment');
Route::get('/myarticleDetail/{id}', [BlogController::class, 'myArticleDetail'])->name('myarticleDetail');

Route::delete('/destroy/{id}', [BlogController::class, 'destroy'])->name('destroy');

Route::post('/blog/{id}', [BlogController::class, 'toggleStatus'])->name('toggleStatus');

// Favorite
Route::post('/blogs{blog}', [FavoriteController::class, 'toggle'])->name('toggleFavorite');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
