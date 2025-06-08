@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create League</h1>
        <form method="POST" action="{{ route('leagues.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">League logo URL:</label>
                <input type="text" name="logo_url" class="form-control" placeholder="https://example.com/logo.jpg">
            </div>
            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create League</button>
        </form>
    </div>
@endsection
