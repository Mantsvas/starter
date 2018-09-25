<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TournamentBattle extends Model
{
    protected $fillable = [
        'tournament_id','field_id','player1_id','player2_id','p1_score','p2_score','winner_id',
    ];

    public function tournament(){
        return $this->belongsTo(Tournament::class,'tournament_id');
    }
    public function player1(){
        return $this->belongsTo(Player::class,'player1_id');
    }
    public function player2(){
        return $this->belongsTo(Player::class,'player2_id');
    }
    public function winner(){
        return $this->belongsTo(Player::class,'winner_id');
    }
}
