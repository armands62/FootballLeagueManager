<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\Matches;
use App\Models\Team;
use App\Models\MatchEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::with('teams')->get();
        return view('leagues.index', compact('leagues'));
    }

    public function create()
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized access.');
        }

        return view('leagues.create');
    }

    public function store(Request $request)
    {

        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|url|max:255',
        ]);

        League::create([
            'name' => $request->name,
            'description' => $request->description,
            'logo_url' => $request->logo_url,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('leagues.index')->with('success', 'League created successfully.');
    }

    public function show(League $league)
    {
        $league->load('teams');

        $filter = request('filter');
        $query = Matches::where('league_id', $league->id)->with(['homeTeam', 'awayTeam']);
        
        if ($filter === 'upcoming') {
            $query->where('match_date', '>=', now());
        }
        $matches = Matches::where('league_id', $league->id)
        ->with(['homeTeam', 'awayTeam', 'events.player', 'events.relatedPlayer'])
        ->orderBy('match_date')
        ->paginate(10);

        $teams = $league->teams;
        $matchesPlayed = Matches::where('league_id', $league->id)
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->get();

        $teamStats = [];

        foreach ($teams as $team) {
            $stats = ['id' => $team->id, 'name' => $team->name, 'logo_url' => $team->logo_url,
                    'mp' => 0, 'w' => 0, 'd' => 0, 'l' => 0, 'gf' => 0, 'ga' => 0, 'gd' => 0, 'pts' => 0];

            foreach ($matchesPlayed as $match) {
                $isHome = $match->home_team_id === $team->id;
                $isAway = $match->away_team_id === $team->id;

                if ($isHome || $isAway) {
                    $stats['mp']++;
                    $gf = $isHome ? $match->home_score : $match->away_score;
                    $ga = $isHome ? $match->away_score : $match->home_score;
                    $stats['gf'] += $gf;
                    $stats['ga'] += $ga;

                    if ($gf > $ga) {
                        $stats['w']++;
                        $stats['pts'] += 3;
                    } elseif ($gf === $ga) {
                        $stats['d']++;
                        $stats['pts'] += 1;
                    } else {
                        $stats['l']++;
                    }
                }
            }

            $stats['gd'] = $stats['gf'] - $stats['ga'];
            $teamStats[] = $stats;
        }

        usort($teamStats, function ($a, $b) {
            return [$b['pts'], $b['gd'], $b['gf']] <=> [$a['pts'], $a['gd'], $a['gf']];
        });

        $standings = $teamStats;

        $topScorers = MatchEvent::with(['player.team'])
        ->select('player_id', DB::raw('COUNT(*) as goal_count'))
        ->where('event_type', 'goal')
        ->whereHas('match', function($q) use ($league) {
            $q->where('league_id', $league->id);
        })
        ->groupBy('player_id')
        ->orderByDesc('goal_count')
        ->take(10)
        ->get();

        return view('leagues.show', compact('league', 'matches', 'standings', 'topScorers'));
    }

    public function edit(League $league)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, League $league)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|url|max:255',
        ]);

        $league->update($request->only('name', 'description', 'logo_url'));

        return redirect()->route('leagues.index')->with('success', 'League updated.');
    }

    public function destroy(League $league)
    {
        if (!auth()->user()->isOrganizer() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        $league->delete();
        return redirect()->route('leagues.index')->with('success', 'League deleted.');
    }
}
