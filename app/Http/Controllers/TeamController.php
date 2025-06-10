<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\League;
use App\Models\Matches;
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
        return view('teams.edit', compact('league', 'team'));
    }

    public function update(Request $request, League $league, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'logo_url' => 'nullable|url',
        ]);

        $team->update($validated);

        return redirect()->route('leagues.show', $league)->with('success', 'Team updated successfully.');
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

    public function show(Team $team)
    {
        $team->load(['players' => function ($query) {
            $query->orderBy('position')->orderBy('kit_number');
        }]);

        $playersByPosition = $team->players->groupBy('position');

        $matches = Matches::where(function($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
        ->with(['homeTeam', 'awayTeam'])
        ->orderBy('match_date')
        ->paginate(10);

        return view('teams.show', compact('team', 'matches', 'playersByPosition'));
    }
}
