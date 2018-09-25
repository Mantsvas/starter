@extends('layouts.app')

@section('content')
<div class="card-body">
    <form class="" action="{{ isset($player) ?  route('players.update',$player) : route('players.store')}}" method="post">
        @csrf
        @if(isset($player))
          @method('PUT')
        @endif

        <div class="form-group row">
            <label for="royale_id" class="col-md-4 col-form-label text-md-right">{{ __('Royale ID') }}</label>

            <div class="col-md-6">
                  <input id="royale_id" type="text" class="form-control{{ $errors->has('royale_id') ? ' is-invalid' : '' }}" name="royale_id" value="{{ isset($player) ? $player->royale_id : old('royale_id') }}" autofocus>

                @if ($errors->has('royale_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('royale_id') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

            <div class="col-md-6">
                  <select id='status' class="form-control" name="status">
                      <option value="1">Yra Klane</option>
                      <option value="0">Nera Klane</option>
                  </select>
                @if ($errors->has('status'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <button type="submit">Save</button>
    </form>
</div>
@endsection
