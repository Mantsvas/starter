<?php

namespace App\Http\Controllers;

use App\War;
use Illuminate\Http\Request;
use App\Player;
use App\PlayerStat;
use App\Post;

class WarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->take(3)->get();
        $wars = War::orderBy('id','desc')->get();
        return view('war.index',compact('wars','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $players = Player::where('status',1)->get();
        return view('war.form',compact('players'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $war = War::create([
            'place' => $request->input('place'),
            'wins' => $request->input('wins'),
            'crowns' => $request->input('crowns'),
            'trophies' => $request->input('trophies'),
            'participiants' => $request->input('participiants'),
            'max_battles' => $request->input('max_battles'),
            'league_type' => $request->input('league_type'),  
        ]);

        for ($i=1; $i < $request->input('participiants') +1  ; $i++) {
            PlayerStat::create([
                'war_id' => $war->id,
                'player_id' => $request->input('player'.$i),
                'score' => $request->input('score'.$i),
                'max_score' => $request->input('max_score'.$i),
                'skipped' => $request->input('skipped'.$i),
            ]);
        }
        return redirect()->route('wars.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\War  $war
     * @return \Illuminate\Http\Response
     */
    public function show(War $war)
    {
        $posts = Post::latest()->take(3)->get();
        return view('war.show',compact('war','posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\War  $war
     * @return \Illuminate\Http\Response
     */
    public function edit(War $war)
    {
        return view('war.form',compact('war'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\War  $war
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, War $war)
    {
        $war->update($request->all());
        return redirect()->route('war.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\War  $war
     * @return \Illuminate\Http\Response
     */
    public function destroy(War $war)
    {
        $war->delete();
        return redirect()->route('war.index');
    }
}
