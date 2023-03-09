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

Route::group(['middleware' => ['auth'], 'prefix' => 'profile', 'as' => 'profile.'],function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('todo-items', TodoItemController::class)->only(['index', 'store']);
    Route::delete('/todo-items/archive/{todo_item}', [TodoItemController::class, 'archive'])->name('todo-items.archive');

    Route::group(['prefix' => 'archive', 'as' => 'archive.'], function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::post('/restore/{todo_item}', [ArchiveController::class, 'restore'])->name('restore');
        Route::delete('/{todo_item}', [ArchiveController::class, 'delete'])->name('delete');
    });
});

require __DIR__.'/auth.php';
