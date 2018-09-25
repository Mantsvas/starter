<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardRarity extends Model
{
    protected $fillable = [
        'name','max_level'
    ];

    public function cards()
    {
        return $this->hasMany(Card::class,'rarity');
    }
}
