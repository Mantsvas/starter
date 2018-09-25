@extends('layouts.app')

@section('content')
<div class="container">
@include('layouts.postWidget')
    <div class="card py-4 my-3">
        <div class="clanTournament_table">
            <h3 class="text-center"><b>War #{{$war->id}} Results</b></h3>
            @foreach($war->playerStats as $stat)
                <div class="row py-2 border-bottom border-dark mx-3">
                    <div class="col-12 col-md-6">
                        {{$loop->iteration}}. <a href="/players/{{$stat->player->id}}"><b>{{$stat->player->username}}</b></a>
                    </div>
                    <div class="col-4 col-md-2 offset-md-0">
                        <b>W: </b>{{$stat->score}}
                    </div>
                    <div class="col-4 col-md-2">
                        <b>P: </b>{{$stat->max_score}}
                    </div>
                    <div class="col-4 col-md-2">
                        <b>S: </b>{{$stat->skipped}}
                    </div>
                </div>
                @if($loop->iteration === 15 || $loop->iteration === 25 || $loop->iteration === 40)


                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
