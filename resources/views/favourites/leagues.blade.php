@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Favourite Leagues</h1>

        @if($leagues->isEmpty())
            <div class="bg-dark text-light border border-warning rounded p-3">
                <strong class="text-warning">No favourite leagues yet!</strong><br>
                You can favourite any league by clicking the “Favourite” button on the leagues page.
            </div>
        @else
            <ul class="list-group">
                @foreach($leagues as $league)
                    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if($league->logo_url)
                                @php
                                    $isLocal = $league->logo_url && !Str::startsWith($league->logo_url, ['http://', 'https://']);
                                @endphp

                                <img 
                                    src="{{ $isLocal ? asset('storage/' . $league->logo_url) : $league->logo_url }}" 
                                    alt="League Logo" 
                                    width="60" 
                                    class="me-3 rounded">
                            @endif

                            <div>
                                <a href="{{ route('leagues.show', $league) }}" class="text-warning fw-bold fs-5 text-decoration-none">
                                    {{ $league->name }}
                                </a>
                                <div class="text-white-50 small">
                                    {{ $league->teams->count() }} team{{ $league->teams->count() !== 1 ? 's' : '' }} in {{ $league->country ?? 'Unknown Country' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('leagues.show', $league) }}" class="btn btn-outline-warning btn-sm">View</a>

                            <form method="POST" action="{{ route('favourites.league.toggle') }}">
                                @csrf
                                <input type="hidden" name="league_id" value="{{ $league->id }}">
                                <button type="submit" class="btn btn-outline-primary btn-sm">
                                    Unfavourite
                                </button>
                            </form>
                            @php
                                $canEdit = auth()->user()->isAdmin() || 
                                        (auth()->user()->isOrganizer() && $league->user_id === auth()->id());
                            @endphp
                            @if($canEdit)
                                <a href="{{ route('leagues.edit', $league) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('leagues.destroy', $league) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this league?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
