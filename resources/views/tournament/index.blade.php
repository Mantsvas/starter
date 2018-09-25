@extends('layouts.app')
@section('content')
<div class="container">
    @include('layouts.postWidget')
    <div class="clanTournament_table">
        <h2 class="text-center mt-5"><b>Tournaments</b></h2>
        <div class="row py-2 border-bottom border-dark mx-3">
            <div class="col-5 offset-1">
                <b>Tournament</b>
            </div>
            <div class="col-3 text-center ">
                <h3><i class="fas fa-medal text-warning"></i></h3>
            </div>
            <div class="col-3 text-center ">
                <h3><i class="fas fa-medal" style="color: rgba(192,192,192,1)"></i></h3>
            </div>
        </div>
        @foreach($tournaments as $tournament)
            <div class="row py-2 border-bottom border-dark mx-3">
                <div class="col-1">
                    #{{$loop->iteration}}
                </div>
                <div class="col-5">
                    <a href="{{route('tournaments.show',$tournament->id)}}"><b>{{$tournament->title}}</b></a>
                </div>
                <div class="col-3 text-center">
                    {{$tournament->champion['username']}}
                </div>
                <div class="col-3 text-center">
                    {{$tournament->secondPlace['username']}}
                </div>
            </div>
            @if($loop->iteration === 10 || $loop->iteration === 20)
            @endif
        @endforeach
    </div>




        <div class="row">
            <a class="btn btn-primary col-10 col-md-2 offset-1 offset-md-5 my-1 p-2" href="{{route('tournaments.rules')}}"><h5><b>Tournament Rules</b></h5></a>
            @auth
                @if(Auth::user()->tournament_moderator === 1)
                    <div class="col-12 text-center">
                        <a class="btn bg-success text-white" href="{{route('tournaments.create')}}">Start New Tournament</a>
                    </div>
                @endif
            @endauth
        </div>
</div>
@endsection
