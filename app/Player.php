<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'royale_id','status',
    ];

    // return players stats from Clan War
    public function playerStats()
    {
        return $this->hasMany(PlayerStat::class);
    }
    // return count of players wins in Clan War
    public function totalWins()
    {
        return $this->hasMany(PlayerStat::class)->sum('score');
    }
    // return count of players games in Clan War
    public function totalPlayed()
    {
        return $this->hasMany(PlayerStat::class)->sum('max_score');
    }

    // return all tournaments where player became champion
    public function champion()
    {
        return $this->hasMany(Tournament::class,'champion_id');
    }
    // return all tournaments where player finished 2nd place
    public function secondPlace()
    {
        return $this->hasMany(Tournament::class,'2nd_place_id');
    }
    // return all tournaments where player finished 3rd place
    public function thirdPlace()
    {
        return $this->hasMany(Tournament::class,'3rd_place_id');
    }
    // return all battles where player played as player 1
    public function player1(){
        return $this->hasMany(TournamentBattle::class,'player1_id');
    }
    // return all battles where player played as player 2
    public function player2(){
        return $this->hasMany(TournamentBattle::class,'player2_id');
    }
    // return all battles where player was a winner
    public function winner(){
        return $this->hasMany(TournamentBattle::class,'winner_id');
    }
    public function playerCards(){
        return $this->hasMany(PlayerCard::class,'royale_id','royale_id');
    }


}
