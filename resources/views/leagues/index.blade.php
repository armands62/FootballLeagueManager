@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Leagues</h1>

        @auth
            @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
                <a href="{{ route('leagues.create') }}" class="btn btn-primary mb-3">Create New League</a>
            @endif
        @endauth

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

                        <a href="{{ route('leagues.show', $league) }}" class="text-warning fw-bold fs-5 text-decoration-none">
                            {{ $league->name }}
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('leagues.show', $league) }}" class="btn btn-outline-warning btn-sm">View</a>

                        @auth
                            @if(auth()->user()->isOrganizer() || auth()->user()->isAdmin())
                                <a href="{{ route('leagues.edit', $league) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('leagues.destroy', $league) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this league?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
