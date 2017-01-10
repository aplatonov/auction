<html>
<head></head>
	<body>
	<p>You received a message from Auction:</p>

	<p>
		Торги по лоту <a href="{{ url($link) }}">{{ $lot_name }}</a></p> завершены.
	</p>
	<hr>
	<p>
		Финальная цена: {{ $final_price }}<br>
		Победитель торга: {{ $winner_name }} ({{ $winner_email }})<br>
		Хозяин лота: {{ $owner_name }} ({{ $owner_email }})<br>
		Дата и время окончания торга {{ $finish_date }}.
	</p>
	<hr>
	</body>
</html>