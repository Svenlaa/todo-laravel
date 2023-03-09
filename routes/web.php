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

Route::group(['middleware' => ['auth'], 'prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::group(['prefix' => 'todo-items', 'as' => 'todo-items.'], function () {
        Route::get('/', [TodoItemController::class, 'index'])->name('index');
        Route::post('/', [TodoItemController::class, 'store'])->name('store');
        Route::delete('/{todo_item}', [TodoItemController::class, 'archive'])->name('archive');
        Route::put('/{todo_item}/toggle', [TodoItemController::class, 'toggle'])->name('toggle');
    });

    Route::group(['prefix' => 'archive', 'as' => 'archive.', 'middleware' => ['auth', 'verified']], function () {
        Route::get('/', [ArchiveController::class, 'index'])->name('index');
        Route::put('/restore/{todo_item}', [ArchiveController::class, 'restore'])->name('restore');
        Route::delete('/{todo_item}', [ArchiveController::class, 'delete'])->name('delete');
    });
});

require __DIR__.'/auth.php';
