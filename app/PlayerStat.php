<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerStat extends Model
{
    protected $fillable = [
        'war_id','player_id','score','max_score','skipped',
    ];

    public function war()
    {
        return $this->belongsTo(War::class);
    }


    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
