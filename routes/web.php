<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\UserWorkController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/works/create', [WorkController::class, 'create'])->name('works.create');
    Route::post('/works', [WorkController::class, 'store'])->name('works.store');

    Route::get('/works/{work}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
    Route::post('/works/{work}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
});

Route::get('/works/{work}', [WorkController::class, 'show'])->name('works.show');

Route::get('/chapter/{chapter}', [ChapterController::class, 'show'])->name('chapter.show');

Route::get('/author-page', [UserWorkController::class, 'index'])
    ->name('user.works')
    ->middleware('auth');

Route::delete('/works/{work}', [WorkController::class, 'destroy'])->name('works.destroy');
Route::get('/works/{work}/edit', [WorkController::class, 'edit'])->name('works.edit');
Route::put('/works/{work}', [WorkController::class, 'update'])->name('works.update');

Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
