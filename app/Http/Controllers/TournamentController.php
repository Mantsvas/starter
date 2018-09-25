<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;
use App\Player;
use App\TournamentBattle;
use App\Post;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->take(3)->get();
        $tournaments = Tournament::all();
        return view('tournament.index',compact('tournaments','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tournament.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tournament::create([
            'title' => $request->input('title'),
        ]);
        return redirect()->route('tournaments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function show(Tournament $tournament)
    {
        $posts = Post::latest()->take(3)->get();
        $players = Player::where('players.status','1')
                    ->orderBy('username')
                    ->get();
        return view('tournament.show',compact('tournament','players','posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function edit(Tournament $tournament)
    {
        return view('tournament.form',compact('tournament'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tournament $tournament)
    {
        $tournament->update([
            'title' => $request->input('title'),
        ]);
        return redirect()->back()->with('success','Turnyras sėkmingai redaguotas!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tournament  $tournament
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('tournaments.index');
    }

    public function rules()
    {
        return view('tournament.rules');
    }
    public function startTournament(Tournament $tournament)
    {
        $count = count($tournament->participiants);
        $order = range(0,$count-1);
        shuffle($order);

        // dd($tournament->participiants[0]->player['username']);
        if($count > 32){
            $this->createTournamentBracket($order,$tournament,33,32,$count);
        } else if($count > 16){
            $this->createTournamentBracket($order,$tournament,17,16,$count);
        }else if($count > 8){
            $this->createTournamentBracket($order,$tournament,9,8,$count);
        }else if($count > 5){
            $this->createTournamentBracket($order,$tournament,5,4,$count);
        }else {
            return redirect()->back()->with('warning','Nepakanka dalyvių');
        }
        $tournament->update([
            'status' => 1,
        ]);
        return redirect()->back()->with('success','Turnyras sėkmingai prasidėjo!');


    }
    public function createTournamentBracket($order,$tournament,$firstField,$battlesPerRound,$count)
    {
        $battles = [];
        for ($i=0; $i < $battlesPerRound; $i++) {
            $battle = $this->storeBattleWithOnePlayer($tournament->id,$i+$firstField,$tournament->participiants[$order[$i]]->player['id']);
            array_push($battles,$battle);
        }
        for ($i=0; $i < $count - $battlesPerRound; $i++) {
            $this->addSecondPlayerToBattle($battles[$i],$tournament->participiants[$order[$i+$battlesPerRound]]->player['id']);
        }
        while($battlesPerRound !== 1){
            $battlesPerRound /= 2;
            $firstField -= $battlesPerRound;
            for ($i=0; $i < $battlesPerRound ; $i++) {
                $this->storeEmptyBattle($tournament->id,$i+$firstField);
            }
        }
        $this->checkTournamentBattlesHasTwoPlayers($tournament);

        return;
    }
    public function storeBattleWithOnePlayer($tournamentId,$fieldId,$playerId)
    {

        $battle = TournamentBattle::create([
            'tournament_id' => $tournamentId,
            'field_id' => $fieldId,
            'player1_id' => $playerId,
        ]);
        return $battle;
    }
    public function storeEmptyBattle($tournamentId,$fieldId){
        $battle = TournamentBattle::create([
            'tournament_id' => $tournamentId,
            'field_id' => $fieldId,
        ]);
        return;
    }
    public function addFirstPlayerToBattle($battle,$playerId)
    {
        $battle->update([
            'player1_id' => $playerId,
        ]);
        return;
    }
    public function addSecondPlayerToBattle($battle,$playerId)
    {
        $battle->update([
            'player2_id' => $playerId,
        ]);
        return;
    }
    public function checkTournamentBattlesHasTwoPlayers($tournament)
    {
        foreach ($tournament->battles as $battle) {
            if (isset($battle->player1_id) && $battle->player2_id === null ) {
                $battle->update([
                    'winner_id' => $battle->player1_id,
                ]);
                $fieldId = round($battle->field_id / 2);
                $newBattle = TournamentBattle::where('tournament_id',$tournament->id)
                                ->where('field_id',$fieldId)
                                ->first();
                if(($battle->field_id/2) < $fieldId){
                    $this->addFirstPlayerToBattle($newBattle,$battle->winner_id);
                } else {
                    $this->addSecondPlayerToBattle($newBattle,$battle->winner_id);
                }
            }
        }
        return;
    }
    public function storeBattleResult(TournamentBattle $battle,Request $request)
    {
        $p1Score = $request->input('p1_score');
        $p2Score = $request->input('p2_score');
        if($p1Score === $p2Score){
            return redirect()->back()->with('warning','Rezultatas negali būti lygus!');
        } elseif ($p1Score < 3 && $p2Score < 3) {
            return redirect()->back()->with('warning','Vienas iš žaidėjų turi surinkti 3 pergales!');
        }
        $winner = $this->selectWinner($p1Score,$p2Score,$battle);
        $battle->update([
            'p1_score' => $p1Score,
            'p2_score' => $p2Score,
            'winner_id' => $winner,
        ]);
        $this->checkIfFinal($battle);
        $fieldId = round($battle->field_id / 2);
        $newBattle = TournamentBattle::where('tournament_id',$battle['tournament_id'])
                        ->where('field_id',$fieldId)
                        ->first();
        if($battle->field_id/2 > 1){
            if(($battle->field_id/2) < $fieldId ){
                $this->addSecondPlayerToBattle($newBattle,$battle->winner_id);
            } else {
                $this->addFirstPlayerToBattle($newBattle,$battle->winner_id);
            }
        }
        return redirect()->back()->with('success','Rezultatas sėkmingai išsaugotas!');
    }
    protected function checkIfFinal(TournamentBattle $battle)
    {
        if($battle->field_id === 2){
            if($battle->winner->id === $battle->player1_id){
                $loser = $battle->player2_id;
            } elseif ($battle->winner->id === $battle->player2_id) {
                $loser = $battle->player1_id;
            }
            $battle->tournament->update([
                'champion_id' => $battle->winner->id,
                '2nd_place_id' => $loser,
                'status' => 2,
            ]);
        }
        return;
    }

    public function selectWinner($p1Score,$p2Score,$battle)
    {
        $winner;
        if ($p1Score > $p2Score) {
            return $battle['player1_id'];
        } else {
            return $battle['player2_id'];
        }
    }
}
