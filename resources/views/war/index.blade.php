@extends('layouts.app')

@section('content')
<div class="container">
@include('layouts.postWidget')
    <div class="row">

            @foreach($wars as $war)
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card mb-3">
                    <div class="card-header bg-dark"><a class="text-white" href="{{route('wars.show',$war)}}">{{ __('War') }} #{{$war->id}}</a></div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mx-1 py-1 border-bottom">
                            <div class=" d-inline">{{__('Places')}}:</div>
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
                            <a href="{{route('wars.show',$war)}}" class="btn btn-danger mt-2"><div>{{__('More Details')}}</div></a>
                        </div>
                    </div>
                </div>

            </div>
            @if($loop->iteration === 4 || $loop->iteration === 8 || $loop->iteration === 12)

                <!-- Google Ad -->
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- ClashRoyale.lt -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-6061339393015125"
                     data-ad-slot="1287933032"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <!-- /Google Ad -->

            @endif
            @endforeach
    </div>
</div>
@endsection
