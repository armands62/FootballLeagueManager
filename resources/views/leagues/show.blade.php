@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $league->name }}</h1>
    <p>{{ $league->description }}</p>

    @if($league->logo_url)
        @if($league->logo_url)
            @php
                $isLocal = $league->logo_url && !Str::startsWith($league->logo_url, ['http://', 'https://']);
            @endphp

            <img 
                src="{{ $isLocal ? asset('storage/' . $league->logo_url) : $league->logo_url }}" 
                alt="League Logo" 
                width="100" 
                class="mb-3">
        @endif
    @endif

    <ul class="nav nav-tabs mb-3" id="leagueTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-standings" data-bs-toggle="tab" data-bs-target="#standings" type="button" role="tab">Standings & Matches</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-scorers" data-bs-toggle="tab" data-bs-target="#scorers" type="button" role="tab">Top Scorers</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-teams" data-bs-toggle="tab" data-bs-target="#teams" type="button" role="tab">Teams</button>
        </li>
    </ul>

    <div class="tab-content" id="leagueTabsContent">
        <div class="tab-pane fade show active" id="standings" role="tabpanel">
            @include('leagues.partials.standings')
            @include('leagues.partials.matches')
        </div>

        <div class="tab-pane fade" id="scorers" role="tabpanel">
            @include('leagues.partials.scorers')
        </div>

        <div class="tab-pane fade" id="teams" role="tabpanel">
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
                        <a href="{{ route('teams.show', $team) }}" class="text-warning fw-bold text-decoration-none">
                            {{ $team->name }}
                        </a>
                        <span class="ms-2 text-white-50">({{ $team->city }})</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection