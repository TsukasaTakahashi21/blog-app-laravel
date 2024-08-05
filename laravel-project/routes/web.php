<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;


// User
Route::get('/', [UserController::class, 'signUp'])->name('signUp');
Route::get('/login', [UserController::class, 'signIn'])->name('signIn');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [BlogController::class, 'logout'])->name('logout');

// blog
Route::get('/top', [BlogController::class, 'top'])->name('top');
Route::get('/mypage', [BlogController::class, 'mypage'])->name('mypage');

Route::get('/create', [BlogController::class, 'create'])->name('create');
Route::post('/store', [BlogController::class, 'store'])->name('store');

Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
Route::put('/update/{id}', [BlogController::class, 'update'])->name('update');

Route::get('/detail/{id}', [BlogController::class, 'showDetail'])->name('detail');
Route::post('/comment/{id}', [BlogController::class, 'storeComment'])->name('storeComment');
Route::get('/myarticleDetail/{id}', [BlogController::class, 'showMyarticleDetail'])->name('myarticleDetail');

Route::delete('/destroy/{id}', [BlogController::class, 'destroy'])->name('destroy');



