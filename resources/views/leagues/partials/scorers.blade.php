<h2>Top Scorers</h2>
<table class="table table-dark table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Player</th>
            <th>Team</th>
            <th>Goals</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topScorers as $index => $scorer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $scorer->player->name }}</td>
                <td>{{ $scorer->player->team->name }}</td>
                <td>{{ $scorer->goal_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>