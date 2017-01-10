    <div class="span6">

        <h5 class="title-bg">Об аукционе
            <small>Правила и новости</small>
            <button id="btn-client-next" class="btn btn-inverse btn-mini" type="button">&raquo;</button>
            <button id="btn-client-prev" class="btn btn-inverse btn-mini" type="button">&laquo;</button>
        </h5>

        <!-- Client Testimonial Slider-->
        <div id="clientCarousel" class="carousel slide no-margin">
            <!-- Carousel items -->
            <div class="carousel-inner">
                @foreach ($articles as $article)
                    @if ($loop->iteration ==1)
                        <div class="active item">
                    @else
                        <div class="item">
                    @endif

                     <p class="quote-text">{!! $article['descr'] !!}<cite>{{ $article['short_descr'] }}</cite></p>
                </div>
                @endforeach
                
            </div>
        </div>

    </div>