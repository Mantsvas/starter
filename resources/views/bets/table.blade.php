<div class="table table-striped table-hover table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th colspan="2"><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBet">Pridėti</button></th>
                <th class="text-center">Data</th>
                <th class="text-center">Statymas</th>
                <th class="text-center">Koeficientas</th>
                <th class="text-center">Laimėjimas</th>
                <th class="text-center">Platforma</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bets as $bet)
                <tr class="table-row">
                    <td>
                        <form action="{{ route('bets.destroy', $bet) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit" title='Pašalinti statymą'>D</button>
                        </form>
                    </td>
                    <td class="text-right">
                        #{{ $loop->index+1 }}
                    </td>
                    <td class="text-center">{{ $bet->date }}</td>
                    <td class="text-center">{{ $bet->bet_sum . ' Eur' }}</td>
                    <td class="text-center">{{ $bet->rate }}</td>
                    <td class="text-center">
                        @if ($bet->status == 'waiting')
                            <a class="btn btn-success btn-sm" href="{{ route('bets.win', $bet) }}" title='Pažymėti kaip laimėtą'>W</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('bets.lost', $bet) }}" title='Pažymėti kaip pralaimėtą'>L</a>
                        @else
                            {{ $bet->status == 'waiting' ? 'Laukiama' : $bet->winnings . ' Eur' }}
                        @endif
                    </td>
                    <td class="text-center">{{ isset($bet->platform) ? $bet->platform->title : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $bets->links() }}
</div>