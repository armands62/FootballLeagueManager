@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to the Football League Manager</h1>
        <a href="{{ route('leagues.index') }}">Browse Leagues</a>
    </div>
@endsection
