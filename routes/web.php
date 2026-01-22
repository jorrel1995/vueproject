<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.welcome');
    })->name('admin');

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/{id}/edit', [UserController::class, 'update'])->name('users.update');
        Route::get('/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');
    });

    Route::get('developments', function () {
        return Inertia::render('Developments');
    })->name('developments');

    Route::get('{page}', [AdminController::class, 'view'])->name('view');
});

require __DIR__.'/settings.php';
