<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'title','champion_id','status','2nd_place_id','3rd_place_id',
    ];
    public function champion()
    {
        return $this->belongsTo(Player::class,'champion_id');
    }
    public function secondPlace()
    {
        return $this->belongsTo(Player::class,'2nd_place_id');
    }
    public function thirdPlace()
    {
        return $this->belongsTo(Player::class,'3rd_place_id');
    }
    public function participiants()
    {
        return $this->hasMany(TournamentPlayer::class,'tournament_id');
    }
    public function battles()
    {
        return $this->hasMany(TournamentBattle::class,'tournament_id');
    }

}
