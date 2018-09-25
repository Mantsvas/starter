<?php

namespace App\Http\Controllers;

use App\TournamentPlayer;
use App\Tournament;
use Illuminate\Http\Request;

class TournamentPlayerController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tournament = Tournament::where('id',$request->input('tournament_id'))->first();
        foreach ($tournament->participiants as $player) {
            if($request->input('player_id') == $player->player_id ){
                return redirect()->back()->with('warning','Toks žaidėjas jau užregistruotas!');
            }
        }
        TournamentPlayer::create([
            'tournament_id' => $request->input('tournament_id'),
            'player_id' => $request->input('player_id'),
        ]);
        return redirect()->back()->with('success','Žaidėjas sėkmingai užregistruotas turnyrui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TournamentPlayer  $tournamentPlayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(TournamentPlayer $player)
    {
        $player->delete();
        return redirect()->back();
    }


}
