@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create League</h1>
        <form method="POST" action="{{ route('leagues.store') }}" enctype="multipart/form-data" >
            @csrf
            <div class="mb-3">
            <label for="name" class="form-label">League Name</label>
            <input type="text" name="name" class="form-control" value="" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" name="country" class="form-control" value="{{ old('country', $league->country ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="logo_url" class="form-label">Logo URL (optional)</label>
                <input type="url" name="logo_url" class="form-control" value="">
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Upload Logo (optional)</label>
                <input type="file" name="logo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Create League</button>
        </form>
    </div>
@endsection
