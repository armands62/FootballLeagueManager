<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(League $league)
    {
        return view('teams.create', compact('league'));
    }

    public function store(Request $request, League $league)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $team = Team::create($request->only('name', 'city'));
        $league->teams()->attach($team->id);

        return redirect()->route('leagues.show', $league)->with('success', 'Team added to league.');
    }

    public function edit(League $league, Team $team)
    {
        return view('teams.edit', compact('league', 'team'));
    }

    public function update(Request $request, League $league, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $team->update($request->only('name', 'city'));

        return redirect()->route('leagues.show', $league)->with('success', 'Team updated.');
    }

    public function destroy(League $league, Team $team)
    {
        $league->teams()->detach($team->id);
        $team->delete();

        return redirect()->route('leagues.show', $league)->with('success', 'Team removed.');
    }
}
