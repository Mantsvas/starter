@extends('layouts.app')
@section('content')

<div class="container">
    @include('layouts.postWidget')
<!-- Tournament Widget -->
    <div class="card py-4 my-3">
        <div class="clanTournament_table">
            <h3 class="text-center"><b>Tournaments</b></h3>
            @foreach($tournaments as $tournament)
                <div class="row py-2 border-bottom border-dark mx-3">
                    <div class="col-12">
                        {{$loop->iteration}}. <a href="{{route('tournaments.show',$tournament->id)}}"><b>{{$tournament->title}}</b></a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-right pr-5 pt-3">
            <a class="btn btn-info" href="{{route('tournaments.index')}}">All Tournaments</a>
        </div>
    </div>
<!-- /Tournament Widget -->

<!-- Player Widget -->
    <div class="card py-4 my-3">
        <div class="clanTournament_table">
            <h3 class="text-center"><b>War Stats</b></h3>
            @foreach($players as $player)
                <div class="row py-2 border-bottom border-dark mx-3">
                    <div class="col-12 col-md-6">
                        {{$loop->iteration}}. <a href="/players/{{$player->id}}"><b>{{$player->username}}</b></a>
                    </div>
                    <div class="col-4 col-md-2 offset-md-0">
                        <b>W: </b>{{$player->score}}
                    </div>
                    <div class="col-4 col-md-2">
                        <b>L: </b>{{$player->max_score - $player->score - $player->skipped}}
                    </div>
                    <div class="col-4 col-md-2">
                        {{round($player->percentage)}}%
                    </div>
                    @auth
                        @if(Auth::user()->admin === 1)
                            <div class="col-2">
                                <a class="btn btn-danger" href="{{route('players.kick',$player->id)}}">Kick</a>
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
        <div class="text-right pr-5 pt-3">
            <a class="btn btn-info" href="{{route('players.index')}}">Full Table</a>
        </div>
    </div>
<!-- /Player Widget -->


<!-- Last War Widget -->
<div class="card p-4 my-3">
    <div class="clanTournament_table">
        <h3 class="text-center"><b>War Results</b></h3>
        <div class="row">
            @foreach($wars as $war)
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card mb-3 p-0">
                        <div class="card-header bg-dark"><a class="text-white" href="{{route('wars.show',$war)}}">{{ __('War') }} #{{$war->id}}</a></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                                <div class=" d-inline">{{__('Place')}}:</div>
                                <div class="d-inline">{{$war->place}}</div>
                            </div>
                            <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                                <div class=" d-inline">{{__('Wins')}}:</div>
                                <div class="d-inline">{{$war->wins}} {{ __('/')}} {{$war->max_battles}}</div>
                            </div>
                            <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                                <div class=" d-inline">{{__('Crowns')}}:</div>
                                <div class="d-inline">{{$war->crowns}}</div>
                            </div>
                            <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                                <div class=" d-inline">{{__('Participiants')}}:</div>
                                <div class="d-inline">{{$war->participiants}}</div>
                            </div>
                            <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                                <div class=" d-inline">{{__('Trophies')}}:</div>
                                <div class="d-inline">{{$war->trophies}}</div>
                            </div>
                            <div class="text-center">
                                <a href="{{route('wars.show',$war)}}" class="btn btn-danger mt-2"><div>{{__('More...')}}</div></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="text-right pr-5 pt-3">
        <a class="btn btn-info" href="{{route('players.index')}}">All Wars</a>
    </div>
</div>
<!-- /Last War Widget -->


</div>


@endsection
