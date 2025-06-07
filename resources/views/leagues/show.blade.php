@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $league->name }}</h1>
        <p>{{ $league->description }}</p>

        <h2>Teams</h2>

        @auth
            <a href="{{ route('teams.create', $league) }}" class="btn btn-primary mb-3">Add Team</a>
        @endauth

        <ul class="list-group">
            @foreach($league->teams as $team)
                <li class="list-group-item bg-dark text-light">
                    {{ $team->name }} ({{ $team->city }})
                </li>
            @endforeach
        </ul>
    </div>
@endsection
