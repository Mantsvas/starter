<div class="row">
    @foreach($posts as $post)
        <div class="col-12 col-sm-6 col-md-4 {{$loop->iteration === 2 ? 'd-none d-sm-flex' : '' }} {{$loop->iteration === 3 ? 'd-none d-md-flex' : '' }}">
            <div class="row">
                <div class="col-12">
                    <a class="text-dark nounderline" href="{{route('posts.show',$post)}}"><img src="/img/post/cover_images/{{$post->cover_image}}" alt=""></a>
                </div>
                <div class="p-3">
                    <div class="col-12">
                        <a class="text-dark" href="{{route('posts.show',$post)}}"><h5>{{$post->title}}</h5></a>
                    </div>
                    <div class="col-12 mt-2">
                        <p>{{str_limit($post->body, $limit = 200, $end = ' [...]')}}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
