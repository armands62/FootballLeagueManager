@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Enter Result: {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h1>
        <form method="POST" action="{{ route('matches.update', [$league, $match]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">{{ $match->homeTeam->name }} Score:</label>
                <input type="number" name="home_score" class="form-control" required value="{{ $match->home_score }}">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ $match->awayTeam->name }} Score:</label>
                <input type="number" name="away_score" class="form-control" required value="{{ $match->away_score }}">
            </div>
            <button type="submit" class="btn btn-primary">Submit Result</button>
        </form>
    </div>
@endsection
