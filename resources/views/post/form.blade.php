@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="" action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Title <input class="form-control" type="text" name="title" placeholder="Title"></label>
            </div>
            <div class="form-group">
                <select class="" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <h4>Deck</h4>
            @for($i = 1; $i < 9; $i++)
                <div class="form-group">
                    <label>Card {{$i}}
                        <select class="" name="card{{$i}}">
                            @foreach($cards as $card)
                                <option value="{{$card->key}}">{{$card->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            @endfor
            <label>Body </label>
            <div class="form-group">
                <textarea name="body" rows="8" cols="80"></textarea></label>
            </div>
            <div class="form-group">
                <label>Youtube Video <input type="text" name="youtube_url" value=""></label>
            </div>
            <div class="form-group">
                <label>Source URL<input type="text" name="source" value=""></label>
            </div>
            @for($i = 1; $i < 5; $i++)
                <div class="form-group">
                    <label>Card Guide {{$i}}
                        <select class="" name="card_guide{{$i}}">

                            @foreach($cards as $card)
                                <option value="{{$card->id}}">{{$card->name}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <textarea class="form-group" name="card_guide_body{{$i}}" rows="8" cols="80"></textarea>
            @endfor
            <div class="form-group">
                <h4>Early stage</h4>
                <textarea name="early" rows="8" cols="80"></textarea>
            </div>
            <div class="form-group">
                <h4>Late stage</h4>
                <textarea name="late" rows="8" cols="80"></textarea>
            </div>
            <div class="form-group">
                <h4>Cover Image</h4>
                <input type="file" name="cover_image" accept=".jpg, .jpeg, .png">
            </div>
            <div class="form-group">
                <button type="submit" name="button">Publish</button>
            </div>
        </form>
    </div>
@endsection
