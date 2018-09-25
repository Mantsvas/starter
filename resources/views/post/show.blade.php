@extends('layouts.app')
@section('meta')
    <meta property="og:url" content="http://www.clashroyale.lt/posts/{{$post->id}}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{$post->title}}" />
    <meta property="og:description" content="{{str_limit($post->body, $limit = 50, $end = ' [...]')}}" />
    <meta property="og:image" content="http://www.clashroyale.lt/img/post/cover_images/{{$post->cover_image}}" />
@endsection
@section('content')
<img class="d-none" src="http://www.clashroyale.lt/img/post/cover_images/{{$post->cover_image}}" alt="">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.1&appId=1875267865882174&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

  <!-- <a href="https://www.facebook.com/sharer/sharer.php?u=clashroyale.lt/posts/{{$post->id}}&display=popup"> share this </a> -->
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 bg-white">
                <h2>{{$post->title}}</h2>
                <div class="fb-share-button" data-href="http://clashroyale.lt/posts/{{$post->id}}" data-layout="button_count" data-size="large" data-mobile-iframe="true">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fclashroyale.lt%2Fposts%2F32&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                </div>
                <div class="row mb-4 d-md-none">
                    @foreach($cardImages as $cardImage)
                    <div class="col-3">
                        <img src="/img/cards/{{$cardImage}}.png" alt="">
                    </div>
                    @endforeach
                </div>
                <div class="row mb-4 d-none d-md-flex">
                    @for($i = 0; $i < count($cardImages); $i += 2 )
                        <div class="col-3">
                            <div class="row">
                                <div class="col-6">
                                    <img src="/img/cards/{{$cardImages[$i]}}.png" alt="">
                                </div>
                                <div class="col-6">
                                    <img src="/img/cards/{{$cardImages[$i+1]}}.png" alt="">
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="row mt-2">
                    <div class="col-12 ">
                        <p>{{$post->body}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 resp-container">
                        <iframe width="755" height="425" src="{{$post->youtube_url}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 ">
                        <h2>Card Guides</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <img src="/img/cards/{{$post->cardGuide1['key']}}.png" alt="">
                    </div>
                    <div class="col-10">
                        <h5>{{$post->cardGuide1['name']}}</h5>
                            <p>{{$post->card_guide_body1}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <img src="/img/cards/{{$post->cardGuide2['key']}}.png" alt="">
                        </div>
                        <div class="col-10">
                            <h5>{{$post->cardGuide2['name']}}</h5>
                            <p>{{$post->card_guide_body2}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <img src="/img/cards/{{$post->cardGuide3['key']}}.png" alt="">
                        </div>
                        <div class="col-10">
                            <h5>{{$post->cardGuide3['name']}}</h5>
                            <p>{{$post->card_guide_body3}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <img src="/img/cards/{{$post->cardGuide4['key']}}.png" alt="">
                        </div>
                        <div class="col-10">
                            <h5>{{$post->cardGuide4['name']}}</h5>
                            <p>{{$post->card_guide_body4}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <h5>Early Stage Gameplan <span class="purple"><i class="fas fa-tint"></i> x1</span></h5>
                        </div>
                        <div class="col-12 ">
                            <p>{{$post->early}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <h5>Late Stage Gameplan <span class="purple"><i class="fas fa-tint"></i> x2</span></h5>
                        </div>
                        <div class="col-12 ">
                            <p>{{$post->late}}</p>
                        </div>
                    </div>
            </div>

            <!-- Side -->
            <div class="d-none d-lg-inline col-lg-2 offset-1">

            </div>
        </div>

    </div>
@endsection

@section('aside')

@endsection
