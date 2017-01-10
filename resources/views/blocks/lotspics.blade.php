    <h5>У нас продают</h5>
    <ul class="img-feed">
        @foreach ($images as $image)
            <li><a href="/lots/{{ $image['lot_id'] }}"><img src="{{ $image['pic'] }}" alt="{{ $image['lot_id'] }}"></a></li>
            @break($loop->iteration == 12)
        @endforeach
    </ul>