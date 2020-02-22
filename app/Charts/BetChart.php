<?php

namespace App\Charts;

use Auth;
use App\Bet;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class BetChart extends Chart
{
    private $months;

    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->month = [
            1 => 'Sausis',
            2 => 'Vasaris',
            3 => 'Kovas',
            4 => 'Balandis', 
            5 => 'Gegužė', 
            6 => 'Birželis', 
            7 => 'Liepa', 
            8 => 'Rugpjūtis', 
            9 => 'Rugsėjis', 
            10 => 'Spalis', 
            11 => 'Lapkritis', 
            12 => 'Gruodis'
        ];
    }

    public function winningsChartByMonth()
    {
        $currentMonth = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subYear()->addMonth()->startOfMonth();

        $winnings = Bet::where('user_id', 1)
                            ->where('status', '!=', 'waiting')
                            ->where('date', '>=', $startDate->format('Y-m-d'))
                            ->where('date', '<=', $currentMonth->format('Y-m-d'))
                            ->selectRaw('MONTH(date) as month, sum(winnings) as winnings')
                            ->orderBy('date')
                            ->groupBy('month')
                            ->get();

        $array = [];
        for ($i = $startDate; $startDate <= $currentMonth; $i->addMonth()) {
            $key = $startDate->month;
            $win = $winnings->where('month', $key)->first();
            $array[$i->year . ' ' . $this->month[$key]] = isset($win) ? round($win->winnings, 2) : 0;
        }

        $array = array_reverse($array);

        $betChart = new BetChart;
        $betChart->labels(array_keys($array));
        $betChart->dataset('Laimėjimai pagal mėnesį', 'bar', array_values($array))->color("rgb(244, 129, 67)")->backgroundcolor("rgb(255, 99, 132)");

        return $betChart;
    }

    public function winningsChart()
    {
        $currentMonth = Carbon::now()->endOfMonth();
        $startDate = Carbon::now()->subYear()->addMonth()->startOfMonth();

        $winnings = Bet::where('user_id', 1)
                            ->where('status', '!=', 'waiting')
                            ->where('date', '>=', $startDate->format('Y-m-d'))
                            ->where('date', '<=', $currentMonth->format('Y-m-d'))
                            ->selectRaw('MONTH(date) as month, sum(winnings) as winnings')
                            ->orderBy('date')
                            ->groupBy('month')
                            ->get();

        $array = [];
        $sum = 0;
        for ($i = $startDate; $startDate <= $currentMonth; $i->addMonth()) {
            $key = $startDate->month;
            $win = $winnings->where('month', $key)->first();
            $sum += isset($win) ? round($win->winnings, 2) : 0;
            $array[$this->month[$key]] = $sum;
        }

        $betChart = new BetChart;
        $betChart->labels(array_keys($array));
        $betChart->dataset('Laimėjimai', 'line', array_values($array))->color("rgb(255, 99, 132)")->backgroundcolor("rgb(244, 129, 67)");

        return $betChart;
    }
}
