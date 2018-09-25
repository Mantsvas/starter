<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;
use CR\Api;
use App\CardRarity;

class CardController extends Controller
{
    public function index()
    {
        $rarities = CardRarity::all();
        return view('cards.index',compact('rarities'));
    }

    public function show(Card $card)
    {
        return view('cards.index',compact('card'));
    }

    public function updateCardList()
    {
        $token = env('CLASH_API_KEY');
        $api = new Api($token);
        $cards = $api->getConstants()->getCards();
        foreach ($cards as $card) {
            $oldCard = Card::where('api_id',$card['id'])->first();
            $this->createCard($oldCard,$card);
        }
        return redirect()->back()->with('Cards updated succesfully!');
    }

    public function createCard($oldCard,$card){
        if($oldCard){
            $newCard = $oldCard;
        }else{
            $newCard = new Card;
        }
        $newCard->key = $card['key'];
        $newCard->name = $card['name'];
        $newCard->description = $card['description'];
        $newCard->type = $card['type'];
        $newCard->arena = $card['arena'];
        $newCard->elixir = $card['elixir'];
        $newCard->api_id = $card['id'];
        // $newCard->icon = $card->getIcon();
        if($card['rarity'] == 'Common'){
            $newCard->rarity = 1;
        } elseif($card['rarity'] == 'Rare'){
            $newCard->rarity = 2;
        }elseif ($card['rarity'] == 'Epic') {
            $newCard->rarity = 3;
        }elseif($card['rarity'] == 'Legendary'){
            $newCard->rarity = 4;
        }
        $newCard->save();
        return;
    }
}
