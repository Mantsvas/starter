<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Card;
use App\Category;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin',['except' => ['show','index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(12);
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cards = Card::all();
        $categories = Category::all();
        return view('post.form',compact('cards','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('cover_image');
        $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
        $fileName = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $fileExt = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
        $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
        // save image directly to public folder
        $file->move('img/post/cover_images', $fileNameToStore);
        // $path = $file->storeAs('storage/public/post/cover_images',$fileNameToStore);
        $youtube = $this->getYoutubeEmbedUrl($request->input('youtube_url'));
        Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'cover_image' => $fileNameToStore,
            'category_id' => $request->input('category_id'),
            'source' =>$request->input('source'),
            'card1' =>$request->input('card1'),
            'card2' =>$request->input('card2'),
            'card3' =>$request->input('card3'),
            'card4' =>$request->input('card4'),
            'card5' =>$request->input('card5'),
            'card6' =>$request->input('card6'),
            'card7' =>$request->input('card7'),
            'card8' =>$request->input('card8'),
            'youtube_url' =>$youtube,
            'card_guide1' =>$request->input('card_guide1'),
            'card_guide2' =>$request->input('card_guide2'),
            'card_guide3' =>$request->input('card_guide3'),
            'card_guide_body1' =>$request->input('card_guide_body1'),
            'card_guide_body2' =>$request->input('card_guide_body2'),
            'card_guide_body3' =>$request->input('card_guide_body3'),
            'early' =>$request->input('early'),
            'late' =>$request->input('late'),
        ]);
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->views +=1;
        $post->save();
        $cardImages = [ $post->card1,$post->card2,$post->card3,$post->card4,$post->card5,$post->card6,$post->card7,$post->card8];
        return view('post.show',compact('post','cardImages'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $cards = Card::all();
        return view('post.form',compact('post','cards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'cover_image' => $request->input('cover_image'),
            'category_id' => $request->input('category_id'),
        ]);
        return redirect()->back()->with('success','Post was updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success','Post was deleted');
    }

    public function getYoutubeEmbedUrl($url)
    {
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))(\w+)/i';

    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }
    return 'https://www.youtube.com/embed/' . $youtube_id ;
    }
}
