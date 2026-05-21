<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CategoryController as UserCategoryController;
use App\Http\Controllers\User\CostController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->middleware('role:admin')->group(function() {

        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Admin User Management Routes
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
    Route::middleware('role:user')->group(function() {

        // User Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User Category Routes
        Route::get('/categories/mine', [UserCategoryController::class, 'getMyCategory'])->name('user.categories.mine');
        Route::get('categories', [UserCategoryController::class, 'index'])->name('user.categories.index');
        Route::get('categories/create', [UserCategoryController::class, 'create'])->name('user.categories.create');
        Route::get('categories/{id}', [UserCategoryController::class, 'show'])->name('user.categories.show');
        Route::post('categories', [UserCategoryController::class, 'store'])->name('user.categories.store');
        Route::get('categories/{id}/edit', [UserCategoryController::class, 'edit'])->name('user.categories.edit');
        Route::put('categories/{id}/status-toggle', [UserCategoryController::class, 'statusToggle'])->name('user.categories.status');
        Route::put('categories/{id}', [UserCategoryController::class, 'update'])->name('user.categories.update');
        Route::delete('categories/{id}', [UserCategoryController::class, 'destroy'])->name('user.categories.destroy');

        // User Collection Routes
        Route::resource('/collections', \App\Http\Controllers\User\CollectionController::class);
        Route::get('/collections/{id}/costs', [\App\Http\Controllers\User\CollectionController::class, 'costs'])->name('collections.costs');

        // User Cost Routes - API Endpoints
        Route::post('costs/store', [CostController::class, 'store'])->name('costs.store');
        Route::put('costs/{id}', [CostController::class, 'update'])->name('costs.update');
        Route::delete('costs/{id}', [CostController::class, 'delete'])->name('costs.delete');
    });
});

require __DIR__.'/auth.php';
