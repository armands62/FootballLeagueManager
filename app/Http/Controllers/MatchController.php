<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\Team;
use App\Models\Matches;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index(League $league)
    {
        $matches = Matches::where('league_id', $league->id)
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date')
            ->get();


        return view('matches.index', compact('league', 'matches'));
    }

    public function create(League $league)
    {
        $teams = $league->teams;
        return view('matches.create', compact('league', 'teams'));
    }

    public function store(Request $request, League $league)
    {
        $request->validate([
            'home_team_id' => 'required|different:away_team_id',
            'away_team_id' => 'required',
            'match_date' => 'required|date'
        ]);

        Matches::create([
            'league_id' => $league->id,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'match_date' => $request->match_date
        ]);

        return redirect()->route('leagues.show', $league)->with('success', 'Match created successfully.');
    }

    public function edit(League $league, Matches $match)
    {
        return view('matches.edit', compact('league', 'match'));
    }

    public function update(Request $request, League $league, Matches $match)
    {
        $request->validate([
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0'
        ]);

        $match->update($request->only('home_score', 'away_score'));

        return redirect()->route('leagues.show', $league)->with('success', 'Match result updated.');
    }

    public function generateScheduleForm(League $league)
    {
        return view('matches.schedule', compact('league'));
    }

    public function generateSchedule(Request $request, League $league)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'repeat_count' => 'required|integer|min:1|max:4'
        ]);

        $teams = $league->teams;
        if ($teams->count() < 2) {
            return back()->with('error', 'Not enough teams to schedule matches.');
        }

        $pairings = [];
        $teamIds = $teams->pluck('id')->toArray();
        for ($i = 0; $i < count($teamIds); $i++) {
            for ($j = $i + 1; $j < count($teamIds); $j++) {
                $pairings[] = [$teamIds[$i], $teamIds[$j]];
            }
        }

        $matches = [];
        for ($r = 0; $r < $request->repeat_count; $r++) {
            foreach ($pairings as [$home, $away]) {
                $matches[] = $r % 2 === 0 ? [$home, $away] : [$away, $home];
            }
        }

        shuffle($matches); // Randomizes the match order

        $totalMatches = count($matches);
        $dateStart = \Carbon\Carbon::parse($request->start_date);
        $dateEnd = \Carbon\Carbon::parse($request->end_date);
        $daysAvailable = $dateStart->diffInDays($dateEnd) + 1;

        if ($totalMatches > $daysAvailable) {
            return back()->with('error', 'Date range too short to fit all matches.');
        }

        $matchDates = [];
        for ($i = 0; $i < $totalMatches; $i++) {
            $matchDates[] = $dateStart->copy()->addDays($i);
        }

        foreach ($matches as $index => [$homeId, $awayId]) {
            Matches::create([
                'league_id' => $league->id,
                'home_team_id' => $homeId,
                'away_team_id' => $awayId,
                'match_date' => $matchDates[$index],
            ]);
        }

        return redirect()->route('leagues.show', $league)->with('success', 'Schedule generated successfully.');
    }
}
