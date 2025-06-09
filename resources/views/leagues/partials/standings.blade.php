<h2>Standings</h2>
<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Team</th>
            <th>MP</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
            <th>GF</th>
            <th>GA</th>
            <th>GD</th>
            <th>Pts</th>
        </tr>
    </thead>
    <tbody>
        @foreach($standings as $index => $team)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="d-flex align-items-center gap-2">
                    @if(isset($team['logo_url']))
                        <img src="{{ $team['logo_url'] }}" alt="Logo" width="24" class="rounded">
                    @endif
                    <a href="{{ route('teams.show', $team['id']) }}" class="text-warning text-decoration-none fw-bold">
                        {{ $team['name'] }}
                    </a>
                </td>
                <td>{{ $team['mp'] }}</td>
                <td>{{ $team['w'] }}</td>
                <td>{{ $team['d'] }}</td>
                <td>{{ $team['l'] }}</td>
                <td>{{ $team['gf'] }}</td>
                <td>{{ $team['ga'] }}</td>
                <td>{{ $team['gd'] }}</td>
                <td>{{ $team['pts'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>