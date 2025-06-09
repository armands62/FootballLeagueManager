@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Player: {{ $player->name }}</h1>
    <form method="POST" action="{{ route('players.update', [$team, $player]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Player Name:</label>
            <input type="text" name="name" value="{{ $player->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth:</label>
            <input type="date" name="dob" value="{{ $player->dob }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Position:</label>
            <select name="position" class="form-select" required>
                <option value="Goalkeeper" {{ $player->position === 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                <option value="Defender" {{ $player->position === 'Defender' ? 'selected' : '' }}>Defender</option>
                <option value="Midfielder" {{ $player->position === 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                <option value="Attacker" {{ $player->position === 'Attacker' ? 'selected' : '' }}>Attacker</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nationality:</label>
            <input type="text" name="nationality" value="{{ $player->nationality }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Kit Number:</label>
            <input type="number" name="kit_number" min="1" max="99" value="{{ $player->kit_number }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Player</button>
    </form>
</div>
@endsection
