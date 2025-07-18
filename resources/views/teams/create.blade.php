@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add Team to {{ $league->name }}</h1>
        <form method="POST" action="{{ route('teams.store', $league) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Team Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="logo_url" class="form-label">Logo URL (optional)</label>
                <input type="url" name="logo_url" class="form-control" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">City:</label>
                <input type="text" name="city" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Team</button>
        </form>
    </div>
@endsection
