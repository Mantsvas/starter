@extends('layouts.app')

@section('content')
<div class="card-body text-center">
    <form class="" action="{{ isset($tournament) ?  route('tournaments.update',$tournament) : route('tournaments.store')}}" method="post">
        @csrf
        @if(isset($tournament))
          @method('PUT')
        @endif



        <div class="form-group row">
            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Turnyro pavadinimas') }}</label>

            <div class="col-md-6">
                  <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ isset($tournament) ? $tournament->title : old('title') }}" autofocus>

                @if ($errors->has('title'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <button type="submit">Išsaugoti</button>
    </form>
</div>
@endsection
