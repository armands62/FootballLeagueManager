<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchEvent extends Model
{
    protected $fillable = ['match_id', 'player_id', 'related_player_id', 'event_type', 'minute'];

    public function match(): BelongsTo {
        return $this->belongsTo(Matches::class);
    }

    public function player(): BelongsTo {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function relatedPlayer(): BelongsTo {
        return $this->belongsTo(Player::class, 'related_player_id');
    }
}

