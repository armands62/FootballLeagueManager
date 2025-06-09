<?php

namespace App\Http\Controllers;

use App\Models\MatchEvent;
use App\Models\Matches;
use App\Models\Player;
use Illuminate\Http\Request;

class MatchEventController extends Controller
{
    public function create(Matches $match)
    {
        $players = Player::whereIn('team_id', [$match->home_team_id, $match->away_team_id])->get();
        return view('match_events.create', compact('match', 'players'));
    }

    public function store(Request $request, Matches $match)
    {
        $request->validate([
            'player_id' => 'required|exists:players,id',
            'related_player_id' => 'nullable|exists:players,id',
            'event_type' => 'required|string|in:goal,assist,yellow_card,red_card,substitution,own_goal',
            'minute' => 'required|integer|min:1|max:120',
        ]);

        MatchEvent::create([
            'match_id' => $match->id,
            'player_id' => $request->player_id,
            'related_player_id' => $request->related_player_id,
            'event_type' => $request->event_type,
            'minute' => $request->minute,
        ]);

        return redirect()->route('leagues.show', $match->league_id)->with('success', 'Match event added successfully.');
    }

    public function destroy(MatchEvent $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Match event deleted successfully.');
    }
}
