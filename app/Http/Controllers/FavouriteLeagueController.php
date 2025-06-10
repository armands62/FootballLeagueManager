<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;

class FavouriteLeagueController extends Controller
{
    public function toggle(Request $request)
    {
        $league = League::findOrFail($request->input('league_id'));
        $user = auth()->user();

        if ($user->favouriteLeagues->contains($league->id)) {
            $user->favouriteLeagues()->detach($league->id);
        } else {
            $user->favouriteLeagues()->attach($league->id);
        }

        return back();
    }

    public function index()
    {
        $user = auth()->user();
        $leagues = $user->favouriteLeagues;
        return view('favourites.leagues', compact('leagues'));
    }
}

