<?php

namespace App\Http\Controllers;

use App\Models\League;
use App\Models\Matches;
use App\Models\Team;
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
        $matches = $query->orderBy('match_date')->paginate(10);

        return view('leagues.show', compact('league', 'matches'));
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
