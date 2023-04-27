<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\TechnologyController;
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

    //restore
    Route::post('/projects/{project:slug}/restore', [ProjectController::class, 'restore'])->name('projects.restore')->withTrashed();
    Route::post('/types/{type:slug}/restore', [TypeController::class, 'restore'])->name('types.restore')->withTrashed();
    Route::post('/technologies/{technology:slug}/restore', [TechnologyController::class, 'restore'])->name('technologies.restore')->withTrashed();


    //routes
    Route::resource('types', TypeController::class)->parameters([
        'types' => 'type:slug'
    ])->withTrashed(['show', 'edit', 'update', 'destroy']);

    Route::resource('projects', ProjectController::class)->parameters([
        'projects' => 'project:slug'
    ])->withTrashed(['show', 'edit', 'update', 'destroy']);

    Route::resource('technologies', TechnologyController::class)->parameters([
        'technologies' => 'technology:slug'
    ])->withTrashed(['show', 'edit', 'update', 'destroy']);
});

require __DIR__ . '/auth.php';
