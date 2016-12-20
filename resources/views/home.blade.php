@extends('layouts.app')

@section('confirmregister')
    @if (Auth::user() && Auth::user()['original']['confirmed'] == 0)
        <div class="row">
            <div class="span2">
            </div>
            <div class="span8">
                <h4>Завершение регистрации пользователя</h4>
                <div class="panel-body">
                    @if (Auth::user()['original']['confirmed'] == 0)
                        Данные о пользователе: {{ dump(Auth::user()['original']) }}
                        <br><br><a href="{{ url('/register/confirm/' . Auth::user()['original']['confirmation_code']) }}">Ссылка для подтверждения</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection


@section('content')
    @if (Auth::user()['original']['confirmed'] == 1)
        <div class="post-summary-footer align-right">
            <span class="right">
                <strong>Здравствуйте, {{ Auth::user()->username }}!</strong><br>
                <strong>Ваши ставки (победы): </strong>34 (12)<br>
                <strong>Всего: </strong><i class="icon-shopping-cart"></i> 23, <i class="icon-user"></i> 99</br>
            </span>
        </div>
    @endif
@endsection


@section('carousel')
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
                    @if ($loop->iteration ==1)
                        <div class="active item">
                    @else
                        <div class="item">
                    @endif
                        <a href="/lots/{{ $top_lot['id'] }}"><img src="img/gallery/{{ $top_lot['id'] }}/{{ $top_lot['images'] }}" alt="{{ $top_lot['lot_name'] }}" class="align-left blog-thumb-preview-img" /></a>
                        <div class="post-info clearfix">
                            <h4><small><a href="/lots/{{ $top_lot['id'] }}">{{ $top_lot['lot_name'] }}</a></small></h4>
                            <ul class="blog-details-preview">
                                <li><i class="icon-calendar"></i><strong>Окончание:</strong> <br>{{ $top_lot['end_auction'] }}</li>
                                <li><i class="icon-user"></i><strong>Автор id:</strong> <a href="{{ $top_lot['owner_id'] }}" title="Link">{{ $top_lot['owner_id'] }}</a></li>
                                <li><i class="icon-retweet"></i><strong>Ставок:</strong> XX</li>
                                <li><i class="icon-flag"></i><strong>Стартовая цена: </strong>{{ $top_lot['start_price'] }}</li>
                                <li><i class="icon-bell"></i><strong>Текущая цена: </strong>XXX</li>
                            </ul>
                        </div>
                        <p class="blog-summary">{{ $top_lot['description'] }} <a href="/lots/{{ $top_lot['id'] }}">Подробнее...</a></p>
                    </div>
                @endforeach
            </div> <!-- Carousel inner -->
        </div>  
    </div>
@endsection

@section('articles')
    <div class="span6">

        <h5 class="title-bg">Об аукционе
            <small>Некоторые правила</small>
            <button id="btn-client-next" class="btn btn-inverse btn-mini" type="button">&raquo;</button>
            <button id="btn-client-prev" class="btn btn-inverse btn-mini" type="button">&laquo;</button>
        </h5>

        <!-- Client Testimonial Slider-->
        <div id="clientCarousel" class="carousel slide no-margin">
            <!-- Carousel items -->
            <div class="carousel-inner">

                <div class="active item">
                    <p class="quote-text">Незарегистрированные пользователи могут только просматривать лоты. Для того, чтобы размещать лоты и делать ставки необходимо зарегистрироваться<cite>правила участия в аукционе</cite></p>
                </div>

                <div class="item">
                    <p class="quote-text">Администратор имеет право заблокировать любого пользователя и лот, если он нарушает правила аукциона<cite>правила участия в аукционе</cite></p>
                </div>

                <div class="item">
                    <p class="quote-text">Не рассуждай, не хлопочи!..<br>
                                          Безумство ищет, глупость судит;<br>
                                          Дневные раны сном лечи,<br>
                                          А завтра быть чему, то будет.<br>
                                          <br>
                                          Живя, умей все пережить:<br>
                                          Печаль, и радость, и тревогу.<br>
                                          Чего желать? О чем тужить?<br>
                                          День пережит — и слава богу!<cite>Федор Тютчев</cite></p>
                </div>
                
            </div>
        </div>

    </div>
@endsection

@section('title')
    <div class="span12">
        <h2 class="title-on-pagination">{{ $title }}</h2>
    </div>
@endsection

@section('gallery')
    <div class="span12 gallery">
        <!-- Pagination -->
        <div class="no-margin pagination">
            {{ $lots->links('vendor.pagination.default') }}
        </div>

        <div class="row clearfix">
            <ul class="gallery-post-grid holder">
                @foreach ($lots as $lot)
                    <!-- Gallery Item -->
                    <li  class="span3 gallery-item" data-id="id-{{ $lot['id'] }}" data-type="illustration">
                        <span class="gallery-hover-4col hidden-phone hidden-tablet">
                            <span class="gallery-icons">
                                <a href="img/gallery/{{ $lot['id'] }}/{{ $lot['images'] }}" class="item-zoom-link lightbox" title="{{ $lot['lot_name'] }}" data-rel="prettyPhoto" rel="prettyPhoto"></a>
                                <a href="/lots/{{ $lot['id'] }}" class="item-details-link"></a>
                            </span>
                        </span>
                        <a href="/lots/{{ $lot['id'] }}"><img src="img/gallery/{{ $lot['id'] }}/{{ $lot['images'] }}" alt="{{ $lot['lot_name'] }}"></a>
                        <span class="project-details"><a href="/lots/{{ $lot['id'] }}">{{ $lot['lot_name'] }}</a>{{ $lot['description'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div><!-- End gallery list-->
@endsection

@section('lastlots')
    <h5>Последние лоты</h5>
     <ul class="post-list">
     @foreach ($top_lots as $top_lot)
        <li><a href="/lots/{{ $top_lot['id'] }}">{{ $top_lot['lot_name'] }}</a></li>
     @endforeach
    </ul>
@endsection

@section('lotspics')
    <h5>У нас продают</h5>
    <ul class="img-feed">
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/thumbnail-270x300.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
        <li><a href="{{asset('/')}}"><img src="img/gallery/flickr-img-1.jpg" alt="Image Feed"></a></li>
    </ul>
@endsection