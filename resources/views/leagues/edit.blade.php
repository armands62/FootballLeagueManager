@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit League</h1>

    <form action="{{ route('leagues.update', $league) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">League Name</label>
            <input type="text" name="name" class="form-control" value="{{ $league->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $league->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="logo_url" class="form-label">Logo URL (optional)</label>
            <input type="url" name="logo_url" class="form-control" value="{{ $league->logo_url }}">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Upload Logo (optional)</label>
            <input type="file" name="logo" class="form-control">
        </div>

        @if($league->logo_url)
            @if($league->logo_url)
                @php
                    $isLocal = $league->logo_url && !Str::startsWith($league->logo_url, ['http://', 'https://']);
                @endphp

                <img 
                    src="{{ $isLocal ? asset('storage/' . $league->logo_url) : $league->logo_url }}" 
                    alt="League Logo" 
                    width="60" 
                    height="60" 
                    class="me-2 rounded">
            @endif
        @endif

        <button type="submit" class="btn btn-primary">Update League</button>
    </form>
</div>
@endsection