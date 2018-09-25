<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CR\Api;
use App\PlayerCard;
use App\Card;
use Carbon\Carbon;
use App\Post;
use App\War;


class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = DB::table('players')
                    ->join('player_stats','player_stats.player_id','=','players.id')
                    ->select('players.username','players.id','player_stats.player_id',DB::raw('sum(player_stats.score) as score'), DB::raw('sum(player_stats.max_score) as max_score'),DB::raw('sum(player_stats.skipped) as skipped'),DB::raw('sum(player_stats.score)/(sum(player_stats.max_score)-sum(player_stats.skipped)) * 100 as percentage'))
                    ->where('players.status','1')
                    ->groupBy('player_stats.player_id')
                    ->orderBy('percentage','desc')
                    ->orderBy('score','desc')
                    ->orderBy('max_score','asc')
                    ->get();

        $exPlayers = DB::table('players')
                    ->join('player_stats','player_stats.player_id','=','players.id')
                    ->select('players.username','players.id','player_stats.player_id',DB::raw('sum(player_stats.score) as score'), DB::raw('sum(player_stats.max_score) as max_score'),DB::raw('sum(player_stats.skipped) as skipped'),DB::raw('sum(player_stats.score)/(sum(player_stats.max_score)-sum(player_stats.skipped)) * 100 as percentage'))
                    ->where('players.status','0')
                    ->groupBy('player_stats.player_id')
                    ->orderBy('percentage','desc')
                    ->orderBy('score','desc')
                    ->orderBy('max_score','asc')
                    ->get();
        $lastWar = War::orderBy('id','desc')->first();
        $lastWar = $lastWar->id;
        $posts = Post::latest()->take(3)->get();
        return view('player.index',compact('players','exPlayers','posts','lastWar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('player.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validCharacters = ['0','2','8','9','p','y','l','q','g','r','j','c','u','v','P','Y','L','Q','G','R','J','C','U','V'];
        $royale_id = $request->input('royale_id');
        if($royale_id[0] === '#'){
            $royale_id = str_replace('#','',$royale_id);
        }
        for ($i=0; $i < strlen($royale_id) ; $i++) {
            if(!(in_array($royale_id[$i],$validCharacters))){
                return redirect()->back();
            }
        }
        $player = Player::where('royale_id',$royale_id)->first();
        if(isset($player)){
            return redirect()->route('players.show',$player);
        }
        $player = Player::create([
            'royale_id'=>$royale_id,
        ]);
        $this->updatePlayerInfo($player);
        $this->updatePlayerCards($player);
        return redirect()->route('players.show',$player);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        $updated = $this->calculateUpdatedAgo($player->updated_at);
        $temp = $this->calculateGoldAndCards($player);
        $cards = $temp['cards'];
        $gold = $temp['gold'];
        $cardCounts = $this->calculateCardsCount($player->playerCards);
        $posts = Post::latest()->take(3)->get();
        return view('player.show',compact('player','updated','gold','cards','cardCounts','posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        return view('player.form',compact('player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function update(Player $player)
    {
        $this->updatePlayerInfo($player);
        $this->updatePlayerCards($player);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy(Player $player)
    {
        $player->delete();
        return redirect()->route('players.index');
    }

    // updates player info
    protected function updatePlayerInfo($player)
    {
        $token = env('CLASH_API_KEY');
        $api = new Api($token);
        $playerData = $api->getPlayer([$player->royale_id]);
        $player->username = $playerData['name'];
        $player->trophies = $playerData['trophies'];
        $player->max_trophies = $playerData['stats']->getMaxTrophies();
        $player->total_donation = $playerData['stats']->getTotalDonations();
        $player->tournament_cards_won = $playerData['stats']->getTournamentCardsWon();
        $player->challenge_max_wins = $playerData['stats']->getChallengeMaxWins();
        $player->challenge_cards_won = $playerData['stats']->getChallengeCardsWon();
        $player->level = $playerData['stats']->getLevel();
        if(isset($playerData['leagueStatistics'])){
            $player->current_season_trophies = $playerData['leagueStatistics']['currentSeason']['trophies'];
            if(isset($playerData['leagueStatistics']['currentSeason']['bestTrophies'])){
                $player->current_season_best_trophies = $playerData['leagueStatistics']['currentSeason']['bestTrophies'];
            }
            if(isset($playerData['leagueStatistics']['previousSeason'])){
                $player->previous_season_trophies = $playerData['leagueStatistics']['previousSeason']['trophies'];
                if(isset($playerData['leagueStatistics']['previousSeason']['bestTrophies'])){
                    $player->previous_season_best_trophies = $playerData['leagueStatistics']['previousSeason']['bestTrophies'];
                }
            }
            $player->best_season_id = $playerData['leagueStatistics']['bestSeason']['id'];
            $player->best_season_trophies = $playerData['leagueStatistics']['bestSeason']['trophies'];
        }

        $player->total_games = $playerData['games']['total'];
        $player->total_wins = $playerData['games']['wins'];
        $player->total_losses = $playerData['games']['losses'];
        $player->total_draws = $playerData['games']['draws'];
        $player->war_day_wins = $playerData['games']['warDayWins'];

        // $player->clan_cards_collected = $playerData['stats']->getTotalDonation();
        $player->save();
        return;
    }

    // updates player cards info
    protected function updatePlayerCards($player)
    {
        $token = env('CLASH_API_KEY');
        $api = new Api($token);
        $cards = $api->getPlayer([$player->royale_id])['cards'];
        foreach ($cards as $card) {
            $oldPlayerCard = PlayerCard::where('card_api_id',$card['id'])->where('royale_id',$player->royale_id)->first();
            if($oldPlayerCard){
                $newPlayerCard = $oldPlayerCard;
            }else{
                $newPlayerCard = new PlayerCard;
            }
            $newPlayerCard->royale_id = $player->royale_id;
            $newPlayerCard->card_api_id = $card['id'];
            $newPlayerCard->level = $card['level'];
            $newPlayerCard->count = $card['count'];
            $newPlayerCard->save();
        }
            return;
    }

    // calculate how much gold and cards need to upgrade all cards to max level
    public function calculateGoldAndCards(Player $player)
    {
        $cards = Card::all();
        $cardsSpent = [
            '1' => 0,
            '2' => 2,
            '3' => 6,
            '4' => 16,
            '5' => 36,
            '6' => 86,
            '7' => 186,
            '8' => 386,
            '9' => 786,
            '10' => 1586,
            '11' => 2586,
            '12' => 4586,
            '13' => 9586,
        ];
        $gold = [
            'All' => [0,0],
            'Common'=> [0,0],
            'Rare' => [0,0],
            'Epic' => [0,0],
            'Legendary' => [0,0], // [spent,required]
        ];
        $cardsRequired = [
            'Common'=> 0,
            'Rare' => 0,
            'Epic' => 0,
            'Legendary' => 0,
        ];
        foreach ($cards as $card) {
            if ($card->rarity === 4){
                $gold['Legendary'][1] += 175000;
                $cardsRequired['Legendary'] += $cardsSpent[$card->getRarity['max_level']];;
            } elseif ($card->rarity === 3){
                $gold['Epic'][1] += 184400;
                $cardsRequired['Epic'] += $cardsSpent[$card->getRarity['max_level']];;
            } elseif ($card->rarity === 2){
                $gold['Rare'][1] += 185600;
                $cardsRequired['Rare'] += $cardsSpent[$card->getRarity['max_level']];;
            } elseif ($card->rarity === 1){
                $gold['Common'][1] += 185625;
                $cardsRequired['Common'] += $cardsSpent[$card->getRarity['max_level']];
            }
        }
        $gold['All'][1] = $gold['Legendary'][1] + $gold['Epic'][1] + $gold['Rare'][1] + $gold['Common'][1];
        foreach ($player->playerCards as $playerCard) {
            if ($playerCard->card->rarity === 4){
                $gold['Legendary'][0] += $this->calculateLegendary($playerCard->level);
                $cardsRequired['Legendary'] -= ($cardsSpent[$playerCard->level] + $playerCard->count);
            } elseif ($playerCard->card->rarity === 3){
                $gold['Epic'][0] += $this->calculateEpic($playerCard->level);
                $cardsRequired['Epic'] -= ($cardsSpent[$playerCard->level] + $playerCard->count);
            } elseif ($playerCard->card->rarity === 2){
                $gold['Rare'][0] += $this->calculateRare($playerCard->level);
                $cardsRequired['Rare'] -= ($cardsSpent[$playerCard->level] + $playerCard->count);
            } elseif ($playerCard->card->rarity === 1){
                $gold['Common'][0] += $this->calculateCommon($playerCard->level);
                $cardsRequired['Common'] -= ($cardsSpent[$playerCard->level] + $playerCard->count);
            }
        }
        $gold['All'][0] = $gold['Legendary'][0] + $gold['Epic'][0] + $gold['Rare'][0] + $gold['Common'][0];
        return [
            'gold' => $gold,
            'cards' => $cardsRequired,
        ];
    }


    // calculate how much gold need for specific legendary card to reach max level
    protected function calculateLegendary($level)
    {
        $gold = 0;
        if($level === 5){
            $gold += 175000;
        } elseif($level === 4){
            $gold += 75000;
        } elseif($level === 3){
            $gold += 25000;
        } elseif($level === 2){
            $gold += 5000;
        }
        return $gold;

    }

    // calculate how much gold need for specific epic card to reach max level
    protected function calculateEpic($level)
    {
        $gold = 0;
        if($level === 8){
            $gold += 184400;
        } elseif($level === 7){
            $gold += 84400;
        } elseif($level === 6){
            $gold += 34400;
        } elseif($level === 5){
            $gold += 14400;
        } elseif($level === 4){
            $gold += 6400;
        } elseif($level === 3){
            $gold += 2400;
        } elseif($level === 2){
            $gold += 400;
        }
        return $gold;
    }

    // calculate how much gold need for specific rare card to reach max level
    protected function calculateRare($level)
    {
        $gold = 0;
        if($level === 11){
            $gold += 185600;
        } elseif($level === 10){
            $gold += 85600;
        } elseif($level === 9){
            $gold += 35600;
        } elseif($level === 8){
            $gold += 15600;
        } elseif($level === 7){
            $gold += 7600;
        } elseif($level === 6){
            $gold += 3600;
        } elseif($level === 5){
            $gold += 1600;
        } elseif($level === 4){
            $gold += 600;
        } elseif($level === 3){
            $gold += 200;
        } elseif($level === 2){
            $gold += 50;
        }
        return $gold;
    }

    // calculate how much gold need for specific common card to reach max level
    protected function calculateCommon($level)
    {
        $gold = 0;
        if($level === 13){
            $gold += 185625;
        } elseif($level === 12){
            $gold += 85625;
        } elseif($level === 11){
            $gold += 35625;
        } elseif($level === 10){
            $gold += 15625;
        } elseif($level === 9){
            $gold += 7625;
        } elseif($level === 8){
            $gold += 3625;
        } elseif($level === 7){
            $gold += 1625;
        } elseif($level === 6){
            $gold += 625;
        } elseif($level === 5){
            $gold += 225;
        } elseif($level === 4){
            $gold += 75;
        } elseif($level === 3){
            $gold += 25;
        } elseif($level === 2){
            $gold += 5;
        }
        return $gold;
    }

    // returns time how long record havent been updated
    protected function calculateUpdatedAgo($updated_at)
    {
        $now = Carbon::now();
        $difference = $now->timestamp - $updated_at->timestamp;
        if ($difference > 31557600 ){
            $updated = floor($difference/31557600) . ' years';
        } elseif ($difference > 2592000){
            $updated = floor($difference/2592000) . ' months';
        } elseif ($difference > 86400){
            $updated = floor($difference/86400) . ' days';
        } elseif ($difference > 3600){
            $updated = floor($difference/3600) . ' hours';
        } elseif ($difference > 60){
            $updated = floor($difference/60) . ' minutes';
        } elseif ($difference > 0){
            $updated = $difference . ' seconds';
        }
        return $updated;
    }

    // Calculate how many cards player have of each level
    protected function calculateCardsCount($playerCards)
    {
        $cards = [
            'Common' => [
                '1'=> 0,
                '2'=> 0,
                '3'=> 0,
                '4'=> 0,
                '5'=> 0,
                '6'=> 0,
                '7'=> 0,
                '8'=> 0,
                '9'=> 0,
                '10'=> 0,
                '11'=> 0,
                '12'=> 0,
                '13'=> 0,
            ],
            'Rare' => [
                '1'=> 0,
                '2'=> 0,
                '3'=> 0,
                '4'=> 0,
                '5'=> 0,
                '6'=> 0,
                '7'=> 0,
                '8'=> 0,
                '9'=> 0,
                '10'=> 0,
                '11'=> 0,
            ],
            'Epic' => [
                '1'=> 0,
                '2'=> 0,
                '3'=> 0,
                '4'=> 0,
                '5'=> 0,
                '6'=> 0,
                '7'=> 0,
                '8'=> 0,
            ],
            'Legendary' => [
                '1'=> 0,
                '2'=> 0,
                '3'=> 0,
                '4'=> 0,
                '5'=> 0,
            ],
        ];
        foreach ($playerCards as $card) {
            if($card->card->rarity === 1){
                $cards['Common'][$card->level] +=1;
            } elseif ($card->card->rarity === 2){
                $cards['Rare'][$card->level] +=1;
            } elseif ($card->card->rarity === 3){
                $cards['Epic'][$card->level] +=1;
            } elseif ($card->card->rarity === 4){
                $cards['Legendary'][$card->level] +=1;
            }
        }
        return $cards;
    }

    // updates all players in DB and their cards info
    public function updateAll()
    {
        $players = Player::all();
        foreach ($players as $player) {
                $this->updatePlayerInfo($player);
                $this->updatePlayerCards($player);

        }
        return redirect()->back();
    }

    // kick player from clan
    public function kickPlayerFromClan(Player $player)
    {
        $player->status = 0;
        $player->save();
        return redirect()->back();
    }

    // add player to clan
    public function addPlayerToClan(Player $player)
    {
        $player->status = 1;
        $player->save();
        return redirect()->back();
    }


    public function playersSort(Request $request)
    {
        if ($request->input('league_type') === "All") {
            $leagueType1 = 'Bronze';
            $leagueType2 = 'Silver';
            $leagueType3 = 'Gold';
            $leagueType4 = 'Legendary';
        } else {
            $leagueType1 = $request->input('league_type');
            $leagueType2 = $request->input('league_type');
            $leagueType3 = $request->input('league_type');
            $leagueType4 = $request->input('league_type');
        }

        $players = DB::table('players')
                    ->join('player_stats','player_stats.player_id','=','players.id')
                    ->join('wars','player_stats.war_id','=','wars.id')
                    ->select('players.username','players.id','player_stats.player_id','wars.id','wars.league_type',DB::raw('sum(player_stats.score) as score'), DB::raw('sum(player_stats.max_score) as max_score'),DB::raw('sum(player_stats.skipped) as skipped'),DB::raw('sum(player_stats.score)/(sum(player_stats.max_score)-sum(player_stats.skipped)) * 100 as percentage'))
                    ->where('players.status','1')
                    ->where('wars.id','>',$request->input('war_id_1'))
                    ->where('wars.id','<',$request->input('war_id_2'))
                    ->where(function($q) use ($leagueType1,$leagueType2,$leagueType3,$leagueType4){
                        $q->where('wars.league_type',$leagueType1)
                        ->orWhere('wars.league_type',$leagueType2)
                        ->orWhere('wars.league_type',$leagueType3)
                        ->orWhere('wars.league_type',$leagueType4);
                    })
                    ->groupBy('player_stats.player_id')
                    ->orderBy('percentage','desc')
                    ->orderBy('score','desc')
                    ->orderBy('max_score','asc')
                    ->get();

        $exPlayers = DB::table('players')
                    ->join('player_stats','player_stats.player_id','=','players.id')
                    ->join('wars','player_stats.war_id','=','wars.id')
                    ->select('players.username','players.id','player_stats.player_id','wars.id','wars.league_type',DB::raw('sum(player_stats.score) as score'), DB::raw('sum(player_stats.max_score) as max_score'),DB::raw('sum(player_stats.skipped) as skipped'),DB::raw('sum(player_stats.score)/(sum(player_stats.max_score)-sum(player_stats.skipped)) * 100 as percentage'))
                    ->where('players.status','0')
                    ->where(function($q) use ($leagueType1,$leagueType2,$leagueType3,$leagueType4){
                        $q->where('wars.league_type',$leagueType1)
                        ->orWhere('wars.league_type',$leagueType2)
                        ->orWhere('wars.league_type',$leagueType3)
                        ->orWhere('wars.league_type',$leagueType4);
                    })
                    ->where('wars.id','>',$request->input('war_id_1'))
                    ->where('wars.id','<',$request->input('war_id_2'))
                    ->groupBy('player_stats.player_id')
                    ->orderBy('percentage','desc')
                    ->orderBy('score','desc')
                    ->orderBy('max_score','asc')
                    ->get();
        $lastWar = War::orderBy('id','desc')->first();
        $lastWar = $lastWar->id;
        $posts = Post::latest()->take(3)->get();
        return view('player.index',compact('players','posts','lastWar','exPlayers'));
    }
}
