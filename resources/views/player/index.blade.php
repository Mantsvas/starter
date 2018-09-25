@extends('layouts.app')
@section('content')
<div class="container">
    @include('layouts.postWidget')

    <div class="card px-3 my-3">
        <div class="row mb-3">
            <div class="col-6 btn btn-success members activeButton">
                <b>Members</b>
            </div>
            <div class="col-6 btn btn-info exMembers">
                <b>Ex Members</b>
            </div>
        </div>
        <form class="input-group mb-3" action="{{route('players.sort')}}" method="get">
            <div class="col-12 col-lg-6 offset-lg-6">
                <div class="row text-center">
                    <div class="col-3">
                        From War #
                    </div>
                    <div class="col-3">
                        To war #
                    </div>
                    <div class="col-4">
                        League
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <input class="form-control" type="number" name="war_id_1" value="1">
                    </div>
                    <div class="col-3">
                        <input class="form-control" type="number" name="war_id_2" value="{{$lastWar}}">
                    </div>
                    <div class="col-3">
                        <select class="form-control" name="league_type">
                            <option value="All">All</option>
                            <option value="Bronze">Bronze</option>
                            <option value="Silver">Silver</option>
                            <option value="Gold">Gold</option>
                            <option value="Legendary">Legendary</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-success" type="submit" name="button">Sort</button>
                    </div>
                </div>
            </div>
        </form>
        <div id="members" class="clanTournament_table">
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

                @if($loop->iteration === 10 || $loop->iteration === 20 || $loop->iteration === 30)


                @endif
            @endforeach
        </div>
        <div id="exMembers" class="clanTournament_table d-none">
            @foreach($exPlayers as $exPlayer)
                <div class="row py-2 border-bottom border-dark mx-3">
                    <div class="col-12 col-md-6">
                        {{$loop->iteration}}. <a href="/players/{{$exPlayer->id}}"><b>{{$exPlayer->username}}</b></a>
                    </div>
                    <div class="col-4 col-md-2 offset-md-0">
                        <b>W: </b>{{$exPlayer->score}}
                    </div>
                    <div class="col-4 col-md-2">
                        <b>L: </b>{{$exPlayer->max_score - $exPlayer->score - $exPlayer->skipped}}
                    </div>
                    <div class="col-4 col-md-2">
                        {{round($exPlayer->percentage)}}%
                    </div>
                    @auth
                        @if(Auth::user()->admin === 1)
                            <div class="col-2">
                                <a class="btn btn-success" href="{{route('players.addToClan',$exPlayer->id)}}">Add to clan</a>
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
    </div>
</div>
<script type="text/javascript">
    let members = function (){
        $('.members').removeClass('btn-info')
        $('.members').addClass('btn-success')
        $('.members').addClass('activeButton')
        $('.exMembers').addClass('btn-info')
        $('.exMembers').removeClass('btn-success')
        $('.exMembers').removeClass('activeButton')
        $('#exMembers').addClass('d-none');
        $('#members').removeClass('d-none');
    }
    let exMembers = function (){
        $('.members').addClass('btn-info')
        $('.members').removeClass('btn-success')
        $('.members').removeClass('activeButton')
        $('.exMembers').removeClass('btn-info')
        $('.exMembers').addClass('btn-success')
        $('.exMembers').addClass('activeButton')
        $('#exMembers').removeClass('d-none');
        $('#members').addClass('d-none');
    }
    $('body').on('click','.members',members);
    $('body').on('click','.exMembers',exMembers);
</script>
@endsection
