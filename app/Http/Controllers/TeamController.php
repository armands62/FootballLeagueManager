<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(League $league)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        return view('teams.create', compact('league'));
    }

    public function store(Request $request, League $league)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url|max:255',
        ]);

        $team = Team::create($request->only('name', 'city', 'logo_url'));
        $league->teams()->attach($team->id);

        return redirect()->route('leagues.show', $league)->with('success', 'Team added to league.');
    }

    public function edit(League $league, Team $team)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        return view('teams.edit', compact('league', 'team'));
    }

    public function update(Request $request, League $league, Team $team)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url|max:255',
        ]);

        $team->update($request->only('name', 'city', 'logo_url'));

        return redirect()->route('leagues.show', $league)->with('success', 'Team updated.');
    }

    public function destroy(League $league, Team $team)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        $league->teams()->detach($team->id);
        $team->delete();

        return redirect()->route('leagues.show', $league)->with('success', 'Team removed.');
    }
}
