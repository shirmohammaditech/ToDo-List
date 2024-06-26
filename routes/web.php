<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Models\Todo;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[TodoController::class, 'index'])->name('dashboard');

    Route::get('/todo',[TodoController::class, 'create']);
    Route::post('/todo',[TodoController::class, 'store']);
    
    Route::get('/todo/{todo}', [TodoController::class, 'edit']);
    Route::post('/todo/{todo}', [TodoController::class, 'update']);
    Route::put('/todo/update-status/{todo}', [TodoController::class, 'updateStatus']);

    
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
