<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class League extends Model
{
    protected $fillable = ['name', 'description', 'user_id', 'logo_url', 'country'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function teams(): BelongsToMany {
        return $this->belongsToMany(Team::class, 'league_team');
    }

    public function matches() {
        return $this->hasMany(Matches::class);
    }

    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'league_user_favourite')->withTimestamps();
    }
}
