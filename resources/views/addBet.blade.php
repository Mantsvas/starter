<div class="modal fade" id="addBet" tabindex="-1" role="dialog" aria-labelledby="addBetLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBetLabel">Statymas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('bets.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required-label-fs">Platforma</label>
                        <select class="form-control" name="platform_id">
                            @foreach ($platforms as $id => $title)
                                <option value="{{ $id }}">{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="required-label-fs">Suma</label>
                        <input class="form-control numericMask" type="text" name="bet_sum">
                    </div>
                    <div class="form-group">
                        <label class="required-label-fs">Koeficentas</label>
                        <input class="form-control numericMask" type="text" name="rate">
                    </div>
                    <div class="form-group">
                        <label class="required-label-fs">Data</label>
                        <input class="form-control" type="date" name="date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Išsaugoti</button>
                </div>
            </form>
        </div>
    </div>
</div>