<?php

namespace App\Http\Controllers;

use Auth;
use App\Bet;
use App\Platform;
use Carbon\Carbon;
use App\Charts\BetChart;
use App\Http\Requests\BetRequest;
use Illuminate\Http\Request;

class BetController extends Controller
{
    public function __construnct()
    {
        $this->middleware('auth');
    }

    public function index(BetChart $betChart)
    {
        if (Auth::user()) {
            return view('bets.index', [
                'bets'              => Bet::where('user_id', Auth::user()->id)->orderBy('date', 'desc')->paginate(50),
                'platforms'         => Platform::pluck('title', 'id'),
                'betsCount'         => Bet::where('user_id', Auth::user()->id)->count(),
                'totalBetsSum'      => Bet::where('user_id', Auth::user()->id)->sum('bet_sum'),
                'totalWinnings'     => Bet::where('user_id', Auth::user()->id)->sum('winnings'),
                'winBetsCount'      => Bet::where(['user_id' => Auth::user()->id, 'status' => 'won'])->count(),
                'lostBetsCount'     => Bet::where(['user_id' => Auth::user()->id, 'status' => 'lost'])->count(),
                'betChartByMonth'   => $betChart->winningsChartByMonth(),
                'betChart'          => $betChart->winningsChart(),
            ]);
        } else {
            return view('bets.index', [
                'bets'              => Bet::where('user_id', 1)->orderBy('date', 'desc')->paginate(50),
                'platforms'         => Platform::pluck('title', 'id'),
                'betsCount'         => Bet::where('user_id', 1)->count(),
                'totalBetsSum'      => Bet::where('user_id', 1)->sum('bet_sum'),
                'totalWinnings'     => Bet::where('user_id', 1)->sum('winnings'),
                'winBetsCount'      => Bet::where(['user_id' => 1, 'status' => 'won'])->count(),
                'lostBetsCount'     => Bet::where(['user_id' => 1, 'status' => 'lost'])->count(),
                'betChartByMonth'   => $betChart->winningsChartByMonth(),
                'betChart'          => $betChart->winningsChart(),
            ]);
        }
    }

    public function create()
    {
        return view('bets.edit', [
            'mode'      => 'create',
            'platforms' => Platform::pluck('title', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $bet = new Bet;
        $bet->fill($request->all());
        $bet->date = Carbon::parse($request->get('date'));
        $bet->user_id = Auth::user() ? Auth::user()->id : 1;
        $bet->save();

        return redirect()->route('bets.index');
    }

    public function edit(Bet $bet)
    {
        return view('bets.edit', [
            'mode'      => 'edit',
            'bet'       => $bet,
            'platforms' => Platform::pluck('title', 'id'),
        ]);
    }

    public function update(Request $request, Bet $bet)
    {
        $bet->fill($request->all());
        $bet->user_id = Auth::user() ? Auth::user()->id : 1;
        $bet->winnings = $request->get('bet_sum') * $request->get('rate');
        $bet->save();

        return redirect()->route('bets.index');
    } 

    public function destroy(Bet $bet)
    {
        $bet->delete();
        
        return redirect()->route('bets.index');
    }

    public function win(Bet $bet)
    {
        // if ($bet->user_id != Auth::user()->id) {
        //     return redirect()->back()->with('alert-danger', 'Tai ne jūsų statymas!');
        // }

        $bet->winnings = $bet->bet_sum * $bet->rate - $bet->bet_sum;
        $bet->status = 'won';
        $bet->save();

        return redirect()->back()->with('alert-success', 'Išsaugota');
    }

    public function lost(Bet $bet)
    {
        // if ($bet->user_id != Auth::user()->id) {
        //     return redirect()->back()->with('alert-danger', 'Tai ne jūsų statymas!');
        // }

        $bet->winnings = 0 - $bet->bet_sum;
        $bet->status = 'lost';
        $bet->save();

        return redirect()->back()->with('alert-success', 'Išsaugota');
    }
}
