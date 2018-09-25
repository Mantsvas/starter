@extends('layouts.app')

@section('content')
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1&appId=1875267865882174&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <h1>Deck Guides</h1>
    @auth
        @if(Auth::user()->admin === 1)
            <div class="col-12">
                <a class="btn btn-success" href="{{route('posts.create')}}">New Post</a>
            </div>
        @endif
    @endauth
    <div class="row">
        @foreach($posts as $post)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card m-2">
                    <div class="row">
                        <div class="col-12">
                            <a class="text-dark nounderline" href="{{route('posts.show',$post)}}"><img src="/img/post/cover_images/{{$post->cover_image}}" alt=""></a>
                            <div class="fb-share-button" data-href="http://clashroyale.lt/posts/{{$post->id}}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fclashroyale.lt%2Fposts%2F32&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                            </div>
                        </div>
                        <div class="p-3">
                            <div class="col-12">
                                <a class="text-dark" href="{{route('posts.show',$post)}}"><h5>{{$post->title}}</h5></a>
                            </div>
                            <div class="col-12 mt-2">
                                <p>{{str_limit($post->body, $limit = 200, $end = ' [...]')}}</p>
                            </div>
                            <div class="row">
                                @auth
                                    <div class="col-6 text-left">
                                        @if(Auth::user()->admin === 1)
                                            <div class="row">

                                                <div class="col-6 text-right">
                                                    <a class="btn btn-info" href="{{route('posts.edit',$post)}}">Edit</a>
                                                </div>
                                                <div class="col-6">
                                                    <a class="btn btn-danger" href="{{route('posts.create',$post)}}">Delete</a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endauth
                                <div class="col-6  text-right pr-5">
                                    <h5 class="pr-3"><i class="fas fa-eye"></i> {{$post->views}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-5">
        {{$posts->links()}}
    </div>
@endsection
