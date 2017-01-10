    <div class="span6">
        <h5 class="title-bg"> 
            <small> Лоты, по которым завершаются торги:</small>
            <button id="btn-blog-next" class="btn btn-inverse btn-mini" type="button">&raquo;</button>
            <button id="btn-blog-prev" class="btn btn-inverse btn-mini" type="button">&laquo;</button>
        </h5>

        <div id="blogCarousel" class="carousel slide">

            <!-- Carousel items -->
            <div class="carousel-inner">
                <!-- Blog Item -->
                @foreach ($top_lots as $top_lot)
                    @if ($loop->iteration ==6)
                        @break
                    @endif
                    @if ($loop->iteration ==1)
                        <div class="active item">
                    @else
                        <div class="item">
                    @endif
                        <a href="/lots/{{ $top_lot['id'] }}"><img src="/img/gallery/{{ $top_lot['id'] }}/{{ $top_lot['images'] }}" alt="{{ $top_lot['lot_name'] }}" class="align-left blog-thumb-preview-img" /></a>
                        <div class="post-info clearfix">
                            <h4><small><a href="/lots/{{ $top_lot['id'] }}">{{ $top_lot['lot_name'] }}</a></small></h4>
                            <ul class="blog-details-preview">
                                <li><i class="icon-calendar"></i><strong>Окончание:</strong> <br>{{ $top_lot['end_auction'] }}</li>
                                <li><i class="icon-user"></i><strong>Автор:</strong> {{ $top_lot['owner_name'] }}</li>
                                <li><i class="icon-retweet"></i><strong>Ставок:</strong> {{ $top_lot['bet_count'] }}</li>
                                <li><i class="icon-flag"></i><strong>Стартовая цена: </strong>{{ $top_lot['start_price'] }}</li>
                                <li><i class="icon-bell"></i><strong>Текущая цена: </strong>{{ $top_lot['best_bet'] }}</li>
                            </ul>
                        </div>
                        <p class="blog-summary">{{ $top_lot['description'] }} <a href="/lots/{{ $top_lot['id'] }}">Подробнее...</a></p>
                    </div>
                @endforeach
            </div> <!-- Carousel inner -->
        </div>  
    </div>