@extends('layouts.app')

@auth
    @section('charts')
        @if($betChartByMonth)
            {!! $betChartByMonth->script() !!}
        @endif
        @if($betChart)
            {!! $betChart->script() !!}
        @endif
        
    @endsection

    @section('content')

        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                @include('bets.statistics')
            </div>
        </div>    

        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                @include('bets.table', ['bets' => $bets])
            </div>
        </div>

        @include('addBet')

    @endsection
@endauth