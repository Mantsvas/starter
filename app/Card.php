<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'key','name','description','type','arena','rarity','elixir','api_id',
    ];

    public function getRarity()
    {
        return $this->belongsTo(CardRarity::class,'rarity');
    }
}
