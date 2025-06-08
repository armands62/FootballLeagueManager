<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = ['name', 'city', 'logo_url'];

    public function leagues(): BelongsToMany {
        return $this->belongsToMany(League::class, 'league_team');
    }

    public function players(): HasMany {
        return $this->hasMany(Player::class);
    }

    public function homeMatches() {
        return $this->hasMany(Matches::class, 'home_team_id');
    }

    public function awayMatches() {
        return $this->hasMany(Matches::class, 'away_team_id');
    }
}

