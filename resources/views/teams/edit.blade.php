@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Team</h1>

    <form action="{{ route('teams.update', [$league, $team]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Team Name</label>
            <input type="text" name="name" class="form-control" value="{{ $team->name }}" required>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" class="form-control" value="{{ $team->city }}">
        </div>

        <div class="mb-3">
            <label for="logo_url" class="form-label">Logo URL</label>
            <input type="url" name="logo_url" class="form-control" value="{{ $team->logo_url }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Team</button>
    </form>
</div>
@endsection
