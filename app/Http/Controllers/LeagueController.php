<?php

namespace App\Http\Controllers;

use App\Models\League;
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
        return view('leagues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        League::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('leagues.index')->with('success', 'League created successfully.');
    }

    public function show(League $league)
    {
        $league->load('teams');
        return view('leagues.show', compact('league'));
    }

    public function edit(League $league)
    {
        return view('leagues.edit', compact('league'));
    }

    public function update(Request $request, League $league)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $league->update($request->only('name', 'description'));

        return redirect()->route('leagues.index')->with('success', 'League updated.');
    }

    public function destroy(League $league)
    {
        $league->delete();
        return redirect()->route('leagues.index')->with('success', 'League deleted.');
    }
}
