<html>
<head></head>
<body>
<p>Confirm register from Auction:</p>

<p>
User: {{ $username }} ({{ $email }})
</p>
<hr>
<p>
Confirmation link: <a href="{{ url($link) }}">{{ url($link) }}</a></p>
<hr>
</body>
</html>