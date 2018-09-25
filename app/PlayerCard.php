<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Player;
use CR\Api;

class PlayerCard extends Model
{
    public function card(){
        return $this->belongsTo(Card::class,'card_api_id','api_id');
    }
    public function player(){
        return $this->belongsTo(Player::class,'royale_id','royale_id');
    }
}
