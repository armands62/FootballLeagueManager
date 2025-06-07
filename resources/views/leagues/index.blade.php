@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Leagues</h1>

        @auth
            <a href="{{ route('leagues.create') }}" class="btn btn-primary mb-3">Create New League</a>
        @endauth

        <ul class="list-group">
            @foreach($leagues as $league)
                <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                    <span>{{ $league->name }}</span>
                    <a href="{{ route('leagues.show', $league) }}" class="btn btn-outline-warning btn-sm">View</a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
