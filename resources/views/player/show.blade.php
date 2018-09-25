@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.postWidget')
    <div class="row">
        <div class="col-7 text-center">
            <h3><b>{{$player->username}}</b></h3>
        </div>
        <div class="col-5">
            <a href="{{route('players.update',$player)}}" class="btn btn-success px-5">
                Update Profile
            </a>
        </div>
        <div class="col-4 btn btn-success text-dark border-bottom border-dark stats">
            <b>Stats</b>
        </div>
        <div class="col-4 btn btn-info text-dark border-bottom border-dark maxCards">
            <b>Left to MAX</b>
        </div>
        <div class="col-4 btn btn-info text-dark border-bottom border-dark cardLevels">
            <b>Card Levels</b>
        </div>
    </div>
    <div id="stats" class="row">
        <div class="col-12 col-md-6 px-0">
            <div class="border border-info rounded my-2 px-2 pb-4 pt-2 m-1 bg-white">
                <div class="row">
                    <h5 class="p-3"><b>Trophies</b></h5>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Highest Trophies
                    </div>
                    <div class="col-6 text-right">
                        {{$player->max_trophies}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Trophies
                    </div>
                    <div class="col-6 text-right">
                        {{$player->trophies}}
                    </div>
                </div>
            </div>
            <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                <div class="row">
                    <h5 class="p-3"><b>Stats</b></h5>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Wins
                    </div>
                    <div class="col-6 text-right">
                        {{$player->total_wins}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Losses
                    </div>
                    <div class="col-6 text-right">
                        {{$player->total_losses}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        War Day Wins
                    </div>
                    <div class="col-6 text-right">
                        {{$player->war_day_wins}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Donation
                    </div>
                    <div class="col-6 text-right">
                        {{$player->total_donation}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 px-0">
            <div class="border border-info rounded mt-2 px-2 pb-4 pt-2 m-1 bg-white">
                <div class="row">
                    <h5 class="p-3"><b>Previous Season</b></h5>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Highest Trophies
                    </div>
                    <div class="col-6 text-right">
                        {{$player->previous_season_best_trophies}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Trophies
                    </div>
                    <div class="col-6 text-right">
                        {{$player->previous_season_trophies}}
                    </div>
                </div>
            </div>
            <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                <div class="row">
                    <h5 class="p-3"><b>Best Season</b></h5>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Season
                    </div>
                    <div class="col-6 text-right">
                        {{$player->best_season_id}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Trophies
                    </div>
                    <div class="col-6 text-right">
                        {{$player->best_season_trophies}}
                    </div>
                </div>
            </div>
            <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                <div class="row">
                    <h5 class="p-3"><b>Challenge Stats</b></h5>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Max Wins
                    </div>
                    <div class="col-6 text-right">
                        {{$player->challenge_max_wins}}
                    </div>
                </div>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Cards Won
                    </div>
                    <div class="col-6 text-right">
                        {{$player->challenge_cards_won}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="maxCards" class="row d-none">
        <div class="col-12 col-md-6 px-0">
            <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                <h5 class="p-3"><b>Gold Required to Max Cards</b></h5>
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        Gold
                    </div>
                    <div class="col-3 text-center">
                        Spent
                    </div>
                    <div class="col-3 text-right">
                        Required
                    </div>
                </div>
                @foreach($gold as $rarity => $amount)
                    <div class="row border-bottom border-dark py-2 px-0 mx-1">
                        <div class="col-6 text-left">
                            {{$rarity}} Cards
                        </div>
                        <div class="col-3 text-center">
                            {{number_format($amount[0])}}
                        </div>
                        <div class="col-3 text-right">
                            {{number_format($amount[1] - $amount[0])}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-6 px-0">
            <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                <h5 class="p-3"><b>Cards Required to Max Cards</b></h5>
                @foreach($cards as $rarity => $amount)
                <div class="row border-bottom border-dark py-2 px-0 mx-1">
                    <div class="col-6 text-left">
                        {{$rarity}} Cards
                    </div>
                    <div class="col-6 text-right">
                        {{number_format($amount)}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="cardLevels" class="row d-none">
        @foreach($cardCounts as $rarity => $levels)
            <div class="col-12 col-md-6 px-0">
                <div class="border border-info rounded mt-4 px-2 pb-4 pt-2 m-1 bg-white">
                    <h5 class="p-3"><b>{{$rarity}} Levels</b></h5>
                    @foreach($levels as $level => $count)
                        <div class="row border-bottom border-dark py-2 px-0 mx-1 {{$count === 0 ? 'd-none' : ''}}">
                            <div class="col-6 text-left">
                                @if($rarity === 'Common')
                                    Level {{$level}}
                                @elseif($rarity === 'Rare')
                                    Level {{$level + 2}}
                                @elseif($rarity === 'Epic')
                                    Level {{$level + 5}}
                                @elseif($rarity === 'Legendary')
                                    Level {{$level + 8}}
                                @endif
                            </div>
                            <div class="col-6 text-right">
                                {{$count}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
    <script type="text/javascript">

        let showStats = function (){
            $('.stats').removeClass('btn-info')
            $('.stats').addClass('btn-success')
            $('.maxCards').addClass('btn-info')
            $('.maxCards').removeClass('btn-success')
            $('.cardLevels').addClass('btn-info')
            $('.cardLevels').removeClass('btn-success')

            $('#stats').removeClass('d-none');
            $('#maxCards').addClass('d-none');
            $('#cardLevels').addClass('d-none');
        }
        let showMaxcards = function (){
            $('.stats').addClass('btn-info')
            $('.stats').removeClass('btn-success')
            $('.maxCards').removeClass('btn-info')
            $('.maxCards').addClass('btn-success')
            $('.cardLevels').addClass('btn-info')
            $('.cardLevels').removeClass('btn-success')

            $('#maxCards').removeClass('d-none');
            $('#stats').addClass('d-none');
            $('#cardLevels').addClass('d-none');
        }
        let showCardsLevels = function (){
            $('.stats').addClass('btn-info')
            $('.stats').removeClass('btn-success')
            $('.maxCards').addClass('btn-info')
            $('.maxCards').removeClass('btn-success')
            $('.cardLevels').removeClass('btn-info')
            $('.cardLevels').addClass('btn-success')
            $('#cardLevels').removeClass('d-none');
            $('#stats').addClass('d-none');
            $('#maxCards').addClass('d-none');
        }

        $('body').on('click','.stats',showStats);
        $('body').on('click','.maxCards',showMaxcards);
        $('body').on('click','.cardLevels',showCardsLevels);
    </script>

@endsection
