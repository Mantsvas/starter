@extends('layouts.app')

@section('content')
<div class="card-body">
    <form class="" action="{{ isset($war) ?  route('wars.update',$war) : route('wars.store')}}" method="post">
        @csrf
        @if(isset($war))
          @method('PUT')
        @endif


        <div class="form-group row">
            <label for="league_type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

            <div class="col-md-6">
                <select class="form-control" name="league_type">
                    <option value="Bronze">Bronze</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Legendary" selected>Legendary</option>
                </select>
                @if ($errors->has('league_type'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('league_type') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="place" class="col-md-4 col-form-label text-md-right">{{ __('Place') }}</label>

            <div class="col-md-6">
                  <input id="place" type="text" class="form-control{{ $errors->has('place') ? ' is-invalid' : '' }}" name="place" value="{{ isset($war) ? $war->place : old('place') }}" autofocus>

                @if ($errors->has('place'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('place') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="wins" class="col-md-4 col-form-label text-md-right">{{ __('Wins') }}</label>

            <div class="col-md-6">
                  <input id="wins" type="text" class="form-control{{ $errors->has('wins') ? ' is-invalid' : '' }}" name="wins" value="{{ isset($war) ? $war->wins : old('wins') }}" autofocus>

                @if ($errors->has('wins'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('wins') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="crowns" class="col-md-4 col-form-label text-md-right">{{ __('Crowns') }}</label>

            <div class="col-md-6">
                <input id="crowns" type="text" class="form-control{{ $errors->has('crowns') ? ' is-invalid' : '' }}" name="crowns" value="{{ isset($war) ? $war->crowns : old('crowns') }}" autofocus>

                @if ($errors->has('crowns'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('crowns') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="trophies" class="col-md-4 col-form-label text-md-right">{{ __('Trophies') }}</label>

            <div class="col-md-6">
                <input id="trophies" type="text" class="form-control{{ $errors->has('trophies') ? ' is-invalid' : '' }}" name="trophies" value="{{ isset($war) ? $war->trophies : old('trophies') }}" autofocus>

                @if ($errors->has('trophies'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('trophies') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="participiants" class="col-md-4 col-form-label text-md-right">{{ __('Participiants') }}</label>

            <div class="col-md-6">
                <input id="participiants" type="text" class="form-control{{ $errors->has('participiants') ? ' is-invalid' : '' }}" name="participiants" value="{{ isset($war) ? $war->participiants : old('participiants') }}" autofocus>

                @if ($errors->has('participiants'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('participiants') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="max_battles" class="col-md-4 col-form-label text-md-right">{{ __('Max Battles') }}</label>

            <div class="col-md-6">
                <input id="max_battles" type="text" class="form-control{{ $errors->has('max_battles') ? ' is-invalid' : '' }}" name="max_battles" value="{{ isset($war) ? $war->max_battles : old('max_battles') }}" autofocus>

                @if ($errors->has('max_battles'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('max_battles') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <hr>
        @for($i = 1; $i < 51; $i++)
        <div class="form-group row">
            <label for="player{{$i}}" class="offset-md-2 col-md-2 col-form-label text-md-right">{{ __('Player ') }}{{$i}}</label>

            <div class="col-md-2">
                <select class="" name="player{{$i}}">
                    @foreach($players as $player)
                        <option value="{{$player->id}}">{{$player->username}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="score{{$i}}" class="text-md-right">{{ __('Score ') }}</label>

                <select class="" name="score{{$i}}">
                    @for ($j = 0; $j < 6; $j++)
                        <option value="{{$j}}">{{$j}}</option>
                    @endfor
                </select>

            </div>
            <div class="col-md-2">
                <label for="max_score{{$i}}" class="text-md-right">{{ __('Max Score ') }}</label>
                <select class="" name="max_score{{$i}}">
                    @for ($j = 0; $j < 6; $j++)
                        <option value="{{$j}}">{{$j}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="skipped{{$i}}" class="text-md-right">{{ __('Skipped ') }}</label>
                <select class="" name="skipped{{$i}}">
                    @for ($j = 0; $j < 6; $j++)
                        <option value="{{$j}}">{{$j}}</option>
                    @endfor
                </select>
            </div>
        </div>
        <hr>
        @endfor

        <button type="submit">Save</button>
    </form>
</div>
@endsection
