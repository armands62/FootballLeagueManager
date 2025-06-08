@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Generate Match Schedule for {{ $league->name }}</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('matches.schedule', $league) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Matches per Pair (1 to 4):</label>
            <select name="repeat_count" class="form-select" required>
                @for($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Schedule</button>
    </form>
</div>
@endsection
