@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Player to {{ $team->name }}</h1>
    <form method="POST" action="{{ route('players.store', $team) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Player Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth:</label>
            <input type="date" name="dob" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Position:</label>
            <select name="position" class="form-select" required>
                <option value="Goalkeeper">Goalkeeper</option>
                <option value="Defender">Defender</option>
                <option value="Midfielder">Midfielder</option>
                <option value="Attacker">Attacker</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nationality:</label>
            <input type="text" name="nationality" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Kit Number:</label>
            <input type="number" name="kit_number" min="1" max="99" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Add Player</button>
    </form>
</div>
@endsection
