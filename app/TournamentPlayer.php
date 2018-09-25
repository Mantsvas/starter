<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentPlayer extends Model
{
    protected $fillable = [
        'tournament_id','player_id','starting_position',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class,'tournament_id');
    }
    public function player()
    {
        return $this->belongsTo(Player::class,'player_id');
    }
}
