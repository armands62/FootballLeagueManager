<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\MatchController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

Route::resource('leagues', LeagueController::class);

Route::middleware(['auth'])->group(function () {
    Route::get('leagues/create', [LeagueController::class, 'create'])->name('leagues.create');
    Route::post('leagues', [LeagueController::class, 'store'])->name('leagues.store');
    Route::get('leagues/{league}/edit', [LeagueController::class, 'edit'])->name('leagues.edit');
    Route::put('leagues/{league}', [LeagueController::class, 'update'])->name('leagues.update');
    Route::delete('leagues/{league}', [LeagueController::class, 'destroy'])->name('leagues.destroy');
});

Route::prefix('leagues/{league}')->middleware(['auth'])->group(function () {
    Route::get('teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('matches', [MatchController::class, 'index'])->name('matches.index');
    Route::get('matches/create', [MatchController::class, 'create'])->name('matches.create');
    Route::post('matches', [MatchController::class, 'store'])->name('matches.store');
    Route::get('matches/{match}/edit', [MatchController::class, 'edit'])->name('matches.edit');
    Route::put('matches/{match}', [MatchController::class, 'update'])->name('matches.update');

    Route::get('matches/schedule', [MatchController::class, 'generateScheduleForm'])->name('matches.schedule.form');
    Route::post('matches/schedule', [MatchController::class, 'generateSchedule'])->name('matches.schedule');

});
