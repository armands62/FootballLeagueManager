<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function create(Team $team)
    {
        return view('players.create', compact('team'));
    }

    public function store(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'position' => 'required|in:Goalkeeper,Defender,Midfielder,Attacker'
        ,
            'nationality' => 'nullable|string|max:255',
            'kit_number' => 'nullable|integer|min:1|max:99']);

        $team->players()->create($request->only('name', 'dob', 'position', 'nationality', 'kit_number'));

        return redirect()->route('teams.show', $team)->with('success', 'Player added successfully.');
    }

    public function edit(Team $team, Player $player)
    {
        return view('players.edit', compact('team', 'player'));
    }

    public function update(Request $request, Team $team, Player $player)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
            'position' => 'required|in:Goalkeeper,Defender,Midfielder,Attacker'
        ,
            'nationality' => 'nullable|string|max:255',
            'kit_number' => 'nullable|integer|min:1|max:99']);

        $player->update($request->only('name', 'dob', 'position', 'nationality', 'kit_number'));

        return redirect()->route('teams.show', $team)->with('success', 'Player updated successfully.');
    }

    public function destroy(Team $team, Player $player)
    {
        $player->delete();

        return redirect()->route('teams.show', $team)->with('success', 'Player deleted.');
    }
}
