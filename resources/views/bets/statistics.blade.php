<div class="row">
    <div class="col-12 col-md-6">
        {!! $betChartByMonth->container() !!}
    </div>
    <div class="col-12 col-md-6">
        {!! $betChart->container() !!}
    </div>
</div>
<div class="row">
    <div class="col-3 text-right">
        <p>Atlikta statymų:</p>
        <p>Bendra statymų suma:</p>
        <p>Bendra laimėjimų suma:</p>
    </div>
    <div class="col-3 text-left">
        <p>{{ $betsCount }}</p>
        <p>{{ $totalBetsSum . ' Eur'}}</p>
        <p>{{ $totalWinnings . ' Eur'}}</p>
    </div>
    <div class="col-3 text-right">
        <p>Laimta statymų:</p>
        <p>Pralaimėta satymų:</p>
        <p>Pergalių procentas:</p>
    </div>
    <div class="col-3 text-left">
        <p>{{ $winBetsCount }}</p>
        <p>{{ $lostBetsCount }}</p>
        <p>{{ $winBetsCount || $lostBetsCount ? round($winBetsCount / ($winBetsCount + $lostBetsCount) * 100, 2) : '-' }}%</p>
    </div>
</div>