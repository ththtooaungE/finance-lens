<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
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

    // Admin Routes
    Route::prefix('admin')->middleware('role:admin')->group(function() {

        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');

        // Admin Category Routes
        Route::get('/categories/system', [CategoryController::class, 'getSystemCategory'])->name('admin.categories.system');
        Route::resource('categories', CategoryController::class, [
            'except' => ['show'],
            'names' => [
                'index' => 'admin.categories.index',
                'create' => 'admin.categories.create',
                'store' => 'admin.categories.store',
                'edit' => 'admin.categories.edit',
                'update' => 'admin.categories.update',
                'destroy' => 'admin.categories.destroy',
            ]
        ]);
    });

    // User Routes
    Route::prefix('user')->middleware('role:user')->group(function() {

        // User Category Routes
        Route::get('/categories/mine', [UserCategoryController::class, 'getMyCategory'])->name('user.categories.mine');
        Route::get('categories', [UserCategoryController::class, 'index'])->name('user.categories.index');
        Route::get('categories/create', [UserCategoryController::class, 'create'])->name('user.categories.create');

        Route::get('categories/{id}', [UserCategoryController::class, 'show'])->name('user.categories.show');
        Route::post('categories', [UserCategoryController::class, 'store'])->name('user.categories.store');
        Route::get('categories/{id}/edit', [UserCategoryController::class, 'edit'])->name('user.categories.edit');
        Route::put('categories/{id}', [UserCategoryController::class, 'update'])->name('user.categories.update');
        Route::delete('categories/{id}', [UserCategoryController::class, 'destroy'])->name('user.categories.destroy');
    });

    Route::get('/collections', function () {
        return view('collections.index');
    })->name('collections.index');
});

require __DIR__.'/auth.php';
