@extends('layouts.app')

@section('content')
<div class="container">
    @include('layouts.postWidget')
    @if(session('success'))
      <div class="alert bg-success">
        {{session('success')}}
      </div>
    @endif
    @if(session('warning'))
      <div class="alert bg-danger">
        {{session('warning')}}
      </div>
    @endif
    <!-- Tournament Registrations -->
    @if ($tournament->status === 0)
        <div class="container">

            <h4 class="text-center">Participiants List</h4>

            @foreach($tournament->participiants as $participiant)
                <div class="row border-bottom border-dark">
                    <div class="col-1 offset-md-3 my-3">
                        #{{$loop->iteration}}
                    </div>
                    <div class="col-5 col-md-3 my-3">
                        <b>{{$participiant->player->username}}</b>
                    </div>
                    @auth
                        @if(Auth::user()->tournament_moderator === 1)
                            <div class="col-6 col-md-5 col">
                            <form onsubmit="disable();" class="py-1 prevent_double_submit" action="{{route('tournamentPlayer.destroy',$participiant)}}" method="post">
                                @csrf
                                @method('delete')
                                <button id="remove" class="btn btn-danger" type="submit" name="button">Remove Player</button>
                            </form>
                            </div>
                        @endif
                    @endauth
                </div>
            @endforeach
        </div>
            @auth
                @if(Auth::user()->tournament_moderator === 1)
                    <form onsubmit="disable();" class="prevent_double_submit" action="{{route('tournamentPlayer.store')}}" method="post">
                        @csrf
                        <div class="d-flex justify-content-around my-5">
                            <input type="hidden" name="tournament_id" value="{{$tournament->id}}">
                            <select class="" name="player_id">
                                @foreach($players as $player)
                                        <option value="{{$player->id}}">{{$player->username}}</option>
                                @endforeach
                            </select>
                            <button id="add" class="btn btn-success"  type="submit" name="button">Add Player</button>
                        </div>
                    </form>
                    <div class="text-center">

                        <a class="btn btn-success center" href="{{route('tournaments.startTournament',$tournament)}}">Start Tournament</a>
                    </div>


                @endif
            @endauth

            <!-- Tournament Started -->
    @elseif ($tournament->status >= 1)
        <div class="row text-center">
            @if($tournament->status === 1)
                <div class="col-12 text-center mb-2">
                    <h4>Schedule</h4>
                </div>
                @foreach($tournament->battles as $battle)
                    @if(isset($battle->player1_id) && isset($battle->player2_id) && $battle->winner_id === null )
                        <div class="col-4 col-md-3 col-lg-2 mt-1 mb-1">
                            <div class="border border-dark rounded text-center">
                                <div class="p-1">
                                    <b>{{$battle->player1['username']}}</b>
                                </div>
                                <div class="p-1">
                                    Vs.
                                </div>
                                <div class="p-1">
                                    <b>{{$battle->player2['username']}}</b>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @elseif($tournament->status === 2)
                <div class="col-12 text-center mb-2">
                    <h4>Champion</h4>
                </div>

                <a href="{{route('players.show',$tournament->champion_id)}}" class="col-6 offset-3 col-md-4 offset-md-4 btn btn-warning text-center border border-dark p-2">
                    <h6>{{$tournament->champion->username}}</h6>
                </a>

            @endif


            <div class="col-12 text-center mb-2 mt-2">
                <h4>Bracket</h4>
            </div>
            <div class="outer">
                <div id="tournament" class="container">
                    <ul class="round round-0 {{ count($tournament->participiants) < 33 ? 'd-none' : ''}}">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 32 && $battle->field_id < 65)
                                <li class="spacer">&nbsp;</li>
                                <li class="game game-top"> {{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-1 {{ count($tournament->participiants) < 17 ? 'd-none' : ''}}">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 16 && $battle->field_id < 33)
                                <li class="spacer">&nbsp;</li>
                                <li class="game game-top">{{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-2 {{ count($tournament->participiants) < 9 ? 'd-none' : ''}}">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 8 && $battle->field_id < 17)
                                <li class="spacer">&nbsp;</li>

                                <li class="game game-top">{{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-3">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 4 && $battle->field_id < 9)
                                <li class="spacer">&nbsp;</li>

                                <li class="game game-top">{{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach

                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-4">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 2 && $battle->field_id < 5)
                                <li class="spacer">&nbsp;</li>

                                <li class="game game-top">{{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach
                        <li class="spacer">&nbsp;</li>
                    </ul>
                    <ul class="round round-5">
                        @foreach($tournament->battles as $battle)
                            @if($battle->field_id > 1 && $battle->field_id < 3)
                                <li class="spacer">&nbsp;</li>

                                <li class="game game-top">{{isset($battle->player1['username']) ? $battle->player1['username'] : '-' }} <span>{{$battle->p1_score}}</span></li>
                                <li class="game game-spacer">&nbsp;</li>
                                <li class="game game-bottom ">{{isset($battle->player2['username']) ? $battle->player2['username'] : '-' }} <span>{{$battle->p2_score}}</span></li>
                            @endif
                        @endforeach
                        <li class="spacer">&nbsp;</li>
                    </ul>
                </div>

            </div>
            @auth
                @if(Auth::user()->tournament_moderator === 1)
                    <div class="col-12">
                        <div class="row">
                            @foreach($tournament->battles as $battle)
                                @if(isset($battle->player1_id) && isset($battle->player2_id) && $battle->winner_id === null )
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center mb-1">
                                        <div class="border border-dark rounded text-center">
                                            <form onsubmit="disable();" class="prevent_double_submit" action="{{route('battles.store',$battle)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="p-1">

                                                    <label><b>{{$battle->player1['username']}} W</b>
                                                        <select name="p1_score">
                                                            @for($i = 0; $i < 4;$i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="p-1">
                                                    <label><b>{{$battle->player2['username']}} W</b>
                                                        <select name="p2_score">
                                                            @for($i = 0; $i < 4;$i++)
                                                                <option value="{{$i}}">{{$i}}</option>
                                                            @endfor
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="p-1">
                                                    <button id="score" class="btn btn-success"  type="submit" name="button">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth
        </div>
        @if ($tournament->status === 2)

        @endif
    @endif
</div>

<script type="text/javascript">
function disable(){
    $('#add').attr('disabled', 'true');
    $('#remove').attr('disabled', 'true');
    $('#score').attr('disabled', 'true');
}


</script>
@endsection
