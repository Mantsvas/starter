<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class War extends Model
{
    protected $fillable = [
        'place','wins','crowns','trophies','participiants','max_battles','league_type',
    ];

    public function playerStats()
    {
        return $this->hasMany(PlayerStat::class);
    }
}
