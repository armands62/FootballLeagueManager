@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Team</h1>

    <form action="{{ route('teams.update', [$league, $team]) }}" method="POST" enctype="multipart/form-data">
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
            <label for="logo_url" class="form-label">Logo URL (optional)</label>
            <input type="url" name="logo_url" class="form-control" value="{{ $team->logo_url }}">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo (optional)</label>
            <input type="file" name="logo" class="form-control">
        </div>

        @if($team->logo_url)
            <div class="mb-3">
                <img src="{{ Str::startsWith($team->logo_url, 'logos/') ? Storage::url($team->logo_url) : $team->logo_url }}" alt="Current Logo" width="100">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Team</button>
    </form>
</div>
@endsection