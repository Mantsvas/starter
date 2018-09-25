@extends('layouts.app')

@section('content')

    @foreach($rarities as $rarity)
        <ul>
            @foreach($rarity->cards as $card)
                <li>{{$card->name}}</li>
                <img src="/storage/cards/{{$card->key . '.png'}}" alt="">
            @endforeach
        </ul>
    @endforeach

@endsection
