@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Schedule Match in {{ $league->name }}</h1>
        <form method="POST" action="{{ route('matches.store', $league) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Home Team:</label>
                <select name="home_team_id" class="form-select" required>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Away Team:</label>
                <select name="away_team_id" class="form-select" required>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Match Date:</label>
                <input type="datetime-local" name="match_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Schedule Match</button>
        </form>
    </div>
@endsection
