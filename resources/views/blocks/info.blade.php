    @if (Auth::user()['original']['confirmed'] == 1)
        <div class="post-summary-footer align-right">
            <span class="right">
                <strong>Здравствуйте, {{ Auth::user()->username }}!</strong><br>
                <strong>Ваши лоты/ставки/победы: </strong>{{ $user_lot_count }} / {{ $user_bet_count }} / {{ $user_bet_count_win }}<br>
                <strong>Всего: </strong><i class="icon-gift"></i>{{ $lot_count }} <i class="icon-user"></i>{{ $user_count }}</br>
            </span>
        </div>
    @endif