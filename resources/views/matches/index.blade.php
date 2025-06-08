@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Matches for {{ $league->name }}</h1>
        <a href="{{ route('matches.create', $league) }}" class="btn btn-primary mb-3">Schedule Match</a>

        <ul class="list-group">
            @foreach($matches as $match)
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    <span>
                        {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                        ({{ \Carbon\Carbon::parse($match->match_date)->format('Y-m-d H:i') }})
                    </span>
                    <span>
                        @if(!is_null($match->home_score) && !is_null($match->away_score))
                            Score: {{ $match->home_score }} - {{ $match->away_score }}
                        @else
                            <a href="{{ route('matches.edit', [$league, $match]) }}" class="btn btn-sm btn-warning">Enter Result</a>
                        @endif
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
