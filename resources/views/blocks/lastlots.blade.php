    <h5>Завершающиеся торги</h5>
     <ul class="post-list">
     @foreach ($top_lots as $top_lot)
		@if ($loop->iteration ==6)
			@break
		@endif
        <li><a href="/lots/{{ $top_lot['id'] }}">{{ $top_lot['lot_name'] }}</a></li>
     @endforeach
    </ul>