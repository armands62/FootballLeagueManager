@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $team->name }}</h1>

    @if($team->logo_url)
        <img src="{{ $team->logo_url }}" alt="Logo" width="100" class="mb-3">
    @endif

    <p><strong>City:</strong> {{ $team->city }}</p>

    @auth
        @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
            <a href="{{ route('players.create', $team) }}" class="btn btn-primary mb-4">Add Player</a>
        @endif
    @endauth

    <h3>Players</h3>
    @if($team->players->count())
        <ul class="list-group mb-4">
            @foreach($playersByPosition as $position => $players)
                <h5 class="mt-4 text-warning">{{ $position }}s</h5>
                <ul class="list-group mb-2">
                    @foreach($players as $player)
                        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                            <div>
                                #{{ $player->kit_number }} — {{ $player->name }}
                                ({{ $player->nationality ?? 'Unknown' }})
                            </div>
                            @auth
                                @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('players.edit', [$team, $player]) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('players.destroy', [$team, $player]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this player?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No players yet.</p>
    @endif

    <h3>Matches</h3>
    <ul class="list-group">
        @foreach($matches as $match)
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                <div>
                    @if($match->homeTeam->logo_url)
                        <img src="{{ $match->homeTeam->logo_url }}" width="25" class="me-1">
                    @endif
                    {{ $match->homeTeam->name }}
                    vs
                    {{ $match->awayTeam->name }}
                    @if($match->awayTeam->logo_url)
                        <img src="{{ $match->awayTeam->logo_url }}" width="25" class="ms-1">
                    @endif
                    <div class="text-info">
                        {{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y (D) H:i') }}
                    </div>
                </div>
                <div>
                    @if(!is_null($match->home_score) && !is_null($match->away_score))
                        @if($match->home_team_id == $team->id)
                            @if($match->home_score > $match->away_score)
                                <span class="badge bg-success">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @elseif($match->home_score < $match->away_score)
                                <span class="badge bg-danger">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @elseif($match->home_score == $match->away_score)
                                <span class="badge bg-warning text-dark">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @endif
                        @elseif($match->away_team_id == $team->id)
                            @if($match->away_score > $match->home_score)
                                <span class="badge bg-success">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @elseif($match->away_score < $match->home_score)
                                <span class="badge bg-danger">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @elseif($match->away_score == $match->home_score)
                                <span class="badge bg-warning text-dark">
                                    {{ $match->home_score }} - {{ $match->away_score }}
                                </span>
                            @endif
                        @endif
                    @endif
                    @if(is_null($match->home_score) && is_null($match->away_score))
                        <span class="badge bg-secondary">Not Played</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-3">
        {{ $matches->links() }}
    </div>
</div>
@endsection
