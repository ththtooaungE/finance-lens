<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->group(function() {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

        Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('categories/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('categories/{id}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
    });

    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');

    Route::get('/collections', function () {
        return view('collections.index');
    })->name('collections.index');
});

require __DIR__.'/auth.php';
