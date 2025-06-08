@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $league->name }}</h1>
    <p>{{ $league->description }}</p>

    @if($league->logo_url)
        <img src="{{ $league->logo_url }}" alt="League Logo" width="100" class="mb-3">
    @endif

    <h2>Teams</h2>
    @auth
        @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
            <a href="{{ route('teams.create', $league) }}" class="btn btn-primary mb-3">Add Team</a>
        @endif
    @endauth

    <ul class="list-group mb-4">
        @foreach($league->teams as $team)
            <li class="list-group-item bg-dark text-light d-flex align-items-center">
                @if($team->logo_url)
                    <img src="{{ $team->logo_url }}" alt="Team Logo" width="40" class="me-3">
                @endif
                <strong>{{ $team->name }}</strong> <span class="mx-1"></span> ({{ $team->city }})
            </li>
        @endforeach
    </ul>

    <h2>Matches</h2>

    @auth
        @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
            <a href="{{ route('matches.create', $league) }}" class="btn btn-primary mb-3">Schedule Match</a>
            <a href="{{ route('matches.schedule.form', $league) }}" class="btn btn-warning mb-3 ms-2">Generate Full Schedule</a>
        @endif
    @endauth
    <a href="{{ route('leagues.show', ['league' => $league->id, 'filter' => 'upcoming']) }}" class="btn btn-outline-warning">Upcoming</a>
    <a href="{{ route('leagues.show', $league) }}" class="btn btn-outline-secondary">All Matches</a>


    <ul class="list-group">
        @foreach($matches as $match)
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                <div>
                    @if($match->homeTeam->logo_url)
                        <img src="{{ $match->homeTeam->logo_url }}" alt="Home Logo" width="30" class="me-2">
                    @endif

                    <strong>{{ $match->homeTeam->name }}</strong>
                    <span class="mx-2">vs</span>
                    <strong>{{ $match->awayTeam->name }}</strong>

                    @if($match->awayTeam->logo_url)
                        <img src="{{ $match->awayTeam->logo_url }}" alt="Away Logo" width="30" class="ms-2">
                    @endif

                    <div class="text-info mt-1">
                        {{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y (D) H:i') }}
                    </div>
                </div>

                <div>
                    @if(!is_null($match->home_score) && !is_null($match->away_score))
                        @php
                            if ($match->home_score > $match->away_score) {
                                $badgeClass = 'bg-success'; // Home wins
                            } elseif ($match->home_score < $match->away_score) {
                                $badgeClass = 'bg-danger'; // Home loses
                            } else {
                                $badgeClass = 'bg-warning text-dark'; // Draw
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $match->home_score }} - {{ $match->away_score }}
                        </span>
                    @endif
                    @if(is_null($match->home_score) && is_null($match->away_score))
                        <span class="badge bg-secondary">Not Played</span>
                    @endif

                    @auth
                        @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
                            <a href="{{ route('matches.edit', [$league, $match]) }}" class="btn btn-sm btn-warning ms-2">
                                {{ is_null($match->home_score) ? 'Enter Result' : 'Edit Result' }}
                            </a>
                        @endif
                    @endauth
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-3">
        {{ $matches->links() }}
    </div>

</div>
@endsection
