<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable =[
            'source','title','body','cover_image','category_id','card1','card2','card3','card4','card5','card6','card7','card8','youtube_url','card_guide1','card_guide2','card_guide3','card_guide4','card_guide_body1','card_guide_body4','card_guide_body2','card_guide_body3','early','late',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function cardGuide1()
    {
        return $this->belongsTo(Card::class,'card_guide1');
    }

    public function cardGuide2()
    {
        return $this->belongsTo(Card::class,'card_guide2');
    }

    public function cardGuide3()
    {
        return $this->belongsTo(Card::class,'card_guide3');
    }

    public function cardGuide4()
    {
        return $this->belongsTo(Card::class,'card_guide4');
    }
}
