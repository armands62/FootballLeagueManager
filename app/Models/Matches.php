<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matches extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'league_id', 'home_team_id', 'away_team_id',
        'match_date', 'home_score', 'away_score'
    ];

    public function league(): BelongsTo {
        return $this->belongsTo(League::class);
    }

    public function homeTeam(): BelongsTo {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events(): HasMany {
        return $this->hasMany(MatchEvent::class, 'match_id');
    }
}

