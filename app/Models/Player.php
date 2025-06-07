<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    protected $fillable = ['name', 'dob', 'position', 'team_id'];

    public function team(): BelongsTo {
        return $this->belongsTo(Team::class);
    }
}
