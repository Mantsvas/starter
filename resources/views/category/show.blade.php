@extends('layouts.app')

@section('content')
    @foreach($category->posts as $post)
    <div class="posts row">
        <div class="col-12 col-md-4">
            <img src="/storage/img/{{$post->cover_image}}" alt="">
        </div>
        <div class="col-12 col-md-8">
            <img src="/storage/img/{{$post->title}}" alt="">
        </div>

    </div>
    @endforeach

@endsection
