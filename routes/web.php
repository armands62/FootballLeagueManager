<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

Route::resource('leagues', LeagueController::class);

Route::prefix('leagues/{league}')->group(function () {
    Route::get('teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
});
