<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\ArchiveController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

Route::resource('todo-items', TodoItemController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);

Route::delete('/todo-items/archive/{todo_item}', [TodoItemController::class, 'archive'])
    ->middleware(['auth', 'verified'])
    ->name('todo-items.archive');

Route::get('/archive', [ArchiveController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('archive.index');

Route::delete('/archive/{todo_item}', [ArchiveController::class, 'delete'])
    ->middleware(['auth', 'verified'])
    ->name('archive.delete');

Route::post('/archive/restore/{todo_item}', [ArchiveController::class, 'restore'])
    ->middleware(['auth', 'verified'])
    ->name('archive.restore');

require __DIR__.'/auth.php';
