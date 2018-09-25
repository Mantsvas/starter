<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Player;
use App\Tournament;
use App\War;
use Illuminate\Support\Facades\DB;
use App\Post;


class WelcomeController extends Controller
{
    public function welcome(){
        $tournaments = Tournament::where('status','<','2')->take(5)->get();
        $players = DB::table('players')
                    ->join('player_stats','player_stats.player_id','=','players.id')
                    ->select('players.id','players.username','players.royale_id','player_stats.player_id',DB::raw('sum(player_stats.score) as score'), DB::raw('sum(player_stats.max_score) as max_score'),DB::raw('sum(player_stats.skipped) as skipped'),DB::raw('sum(player_stats.score)/(sum(player_stats.max_score)-sum(player_stats.skipped)) * 100 as percentage'))
                    ->where('players.status','1')
                    ->groupBy('player_stats.player_id')
                    ->orderBy('percentage','desc')
                    ->orderBy('score','desc')
                    ->orderBy('max_score','asc')
                    ->take(10)
                    ->get();
        $wars = War::latest()->take(4)->get();
        $posts = Post::latest()->take(3)->get();
        return view('welcome',compact('tournaments','players','wars','posts'));
    }
}
