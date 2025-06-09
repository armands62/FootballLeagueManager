@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Match Event</h1>
    <h2 class="text-warning mb-3">
    {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
    — {{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y (D) H:i') }}
    </h2>
    <form method="POST" action="{{ route('match-events.store', $match) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Player Involved:</label>
            <select name="player_id" class="form-select" required>
                @foreach($players as $player)
                    <option value="{{ $player->id }}">
                        {{ $player->name }} (#{{ $player->kit_number }}) — {{ $player->team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Related Player (optional):</label>
            <select name="related_player_id" class="form-select">
                <option value="">-- none --</option>
                @foreach($players as $player)
                    <option value="{{ $player->id }}">
                        {{ $player->name }} (#{{ $player->kit_number }}) — {{ $player->team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Event Type:</label>
            <select name="event_type" class="form-select" required>
                <option value="goal">Goal</option>
                <option value="own_goal">Own Goal</option>
                <option value="assist">Assist</option>
                <option value="yellow_card">Yellow Card</option>
                <option value="red_card">Red Card</option>
                <option value="substitution">Substitution</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Minute:</label>
            <input type="number" name="minute" min="1" max="120" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
</div>
@endsection
