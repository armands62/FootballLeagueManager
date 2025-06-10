<h2>Matches</h2>

@auth
    @php
        $canManageMatches = auth()->user()->isAdmin() || 
                           (auth()->user()->isOrganizer() && $league->user_id === auth()->id());
    @endphp
    @if($canManageMatches)
        <a href="{{ route('matches.create', $league) }}" class="btn btn-primary mb-3">Schedule Match</a>
        <a href="{{ route('matches.schedule.form', $league) }}" class="btn btn-warning mb-3 ms-2">Generate Full Schedule</a>
    @endif
@endauth

<a href="{{ route('leagues.show', ['league' => $league->id, 'filter' => 'upcoming']) }}" class="btn btn-outline-warning">Upcoming</a>
<a href="{{ route('leagues.show', $league) }}" class="btn btn-outline-secondary">All Matches</a>

<ul class="list-group mt-3">
    @foreach($matches as $match)
        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
            <div>
                @if($match->homeTeam->logo_url)
                    <img src="{{ $match->homeTeam->logo_url }}" alt="Home Logo" width="30" class="me-2">
                @endif

                <strong>{{ $match->homeTeam->name }}</strong>
                <span class="mx-2">vs</span>
                <strong>{{ $match->awayTeam->name }}</strong>

                @if($match->awayTeam->logo_url)
                    <img src="{{ $match->awayTeam->logo_url }}" alt="Away Logo" width="30" class="ms-2">
                @endif

                <div class="text-info mt-1">
                    {{ \Carbon\Carbon::parse($match->match_date)->format('F j, Y (D) H:i') }}
                </div>
            </div>

            <div>
                @if(!is_null($match->home_score) && !is_null($match->away_score))
                    @php
                        if ($match->home_score > $match->away_score) {
                            $badgeClass = 'bg-success';
                        } elseif ($match->home_score < $match->away_score) {
                            $badgeClass = 'bg-danger';
                        } else {
                            $badgeClass = 'bg-warning text-dark';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        {{ $match->home_score }} - {{ $match->away_score }}
                    </span>
                @else
                    <span class="badge bg-secondary">Not Played</span>
                @endif

                @auth
                    @if($canManageMatches)
                        <a href="{{ route('matches.edit', [$league, $match]) }}" class="btn btn-sm btn-warning ms-2">
                            {{ is_null($match->home_score) ? 'Enter Result' : 'Edit Result' }}
                        </a>
                        <a href="{{ route('match-events.create', $match) }}" class="btn btn-sm btn-outline-light ms-2">
                            Add Event
                        </a>
                    @endif
                @endauth
            </div>
        </li>

        <div class="accordion-body bg-dark px-4 pb-3 pt-1">
            @if($match->events->count())
                <ul class="list-group list-group-flush">
                    @php
                        $sortedEvents = $match->events->sortBy('minute');
                    @endphp

                    @foreach($sortedEvents as $event)
                        <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center border-0 px-0 py-2">
                            <div class="d-flex align-items-center">
                                @php
                                    $icon = match($event->event_type) {
                                        'goal' => '⚽',
                                        'own_goal' => '🥅',
                                        'assist' => '🅰️',
                                        'yellow_card' => '🟨',
                                        'red_card' => '🟥',
                                        'substitution' => '🔄',
                                        default => '📌'
                                    };
                                @endphp
                                <span class="me-2">{{ $icon }}</span>

                                @if($event->player->team->logo_url)
                                    <img src="{{ $event->player->team->logo_url }}" alt="Team Logo" width="24" class="me-2 rounded">
                                @endif

                                <span>{{ $event->player->name }}</span>

                                @if($event->relatedPlayer)
                                    <span class="ms-2 fst-italic" style="opacity: 0.75;">
                                        ({{ $event->relatedPlayer->name }})
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <div class="text-info fw-bold">{{ $event->minute }}'</div>
                                @auth
                                    @if($canManageMatches)
                                        <form action="{{ route('match-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger py-0 px-1">Delete</button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="fst-italic">No events logged for this match.</div>
            @endif
        </div>
    @endforeach
</ul>

<div class="mt-3">
    {{ $matches->links() }}
</div>