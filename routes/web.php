<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;

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

Route::get('/', [LandingController::class, "index"])->name('landing-page');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/analyze_link', [DashboardController::class, 'analyze_link'])->middleware(['auth', 'verified'])->name('analyze_link');

Route::get('/results', [DashboardController::class, 'results'])->middleware(['auth', 'verified'])->name('results');

// i used post so its more secured then get http verb
Route::post('/run_cron_job', [DashboardController::class, 'run_cron_job'])->middleware(['auth', 'verified'])->name('run_cron_job');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
