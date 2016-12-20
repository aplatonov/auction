@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row"><!-- Begin Top Section -->
            <!-- lots Preview
            ================================================== -->
		    <div class="span6">
		        <h5 class="title-bg">Успейте участвовать! 
		            <small> Лоты, по которым завершаются торги:</small>
		            <button id="btn-blog-next" class="btn btn-inverse btn-mini" type="button">&raquo;</button>
		            <button id="btn-blog-prev" class="btn btn-inverse btn-mini" type="button">&laquo;</button>
		        </h5>

		        <div id="blogCarousel" class="carousel slide">

		            <!-- Carousel items -->
		            <div class="carousel-inner">
		                <!-- Blog Item 1 -->
		                <div class="active item">
		                    <a href="{{ url('/') }}"><img src="img/gallery/blog-med-img-1.jpg" alt="" class="align-left blog-thumb-preview" /></a>
		                    <div class="post-info clearfix">
		                        <h4><a href="{{ url('/') }}">Лот №1 Пипетка</a></h4>
		                        <ul class="blog-details-preview">
		                            <li><i class="icon-calendar"></i><strong>Окончание:</strong> <br>22.12.2016 в 14:00</li>
		                            <li><i class="icon-user"></i><strong>Автор:</strong> <a href="{{ url('/') }}" title="Link">username</a></li>
		                            <li><i class="icon-retweet"></i><strong>Ставок:</strong> 12</li>
		                            <li><i class="icon-flag"></i><strong>Стартовая цена: </strong>1000</li>
		                            <li><i class="icon-bell"></i><strong>Текущая цена: </strong>680</li>
		                        </ul>
		                    </div>
		                    <p class="blog-summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In interdum felis fermentum ipsum molestie sed porttitor ligula rutrum. Vestibulum lectus tellus, aliquet et iaculis sed, volutpat vel erat. <a href="#">Подробнее...</a></p>
		                </div>

		                <!-- Blog Item 2-->
		                <div class="item">
		                    <a href="{{ url('/') }}"><img src="img/gallery/blog-med-img-1.jpg" alt="" class="align-left blog-thumb-preview" /></a>
		                    <div class="post-info clearfix">
		                        <h4><a href="{{ url('/') }}">Лот №2 Hektnr</a></h4>
		                        <ul class="blog-details-preview">
		                            <li><i class="icon-calendar"></i><strong>Окончание:</strong> <br>22.12.2016 в 14:00</li>
		                            <li><i class="icon-user"></i><strong>Автор:</strong> <a href="{{ url('/') }}" title="Link">username</a></li>
		                            <li><i class="icon-retweet"></i><strong>Ставок:</strong> 12</li>
		                            <li><i class="icon-flag"></i><strong>Стартовая цена: </strong>1000</li>
		                            <li><i class="icon-bell"></i><strong>Текущая цена: </strong>680</li>
		                        </ul>
		                    </div>
		                    <p class="blog-summary">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In interdum felis fermentum ipsum molestie sed porttitor ligula rutrum. Vestibulum lectus tellus, aliquet et iaculis sed, volutpat vel erat. <a href="#">Подробнее...</a></p>
		                </div>
		            </div> <!-- Carousel inner -->
		        </div>  
		    </div>


            <!-- articles Area
            ================================================== -->
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

            
        </div><!-- End Top Section -->

        <!-- Gallery Items
        ================================================== --> 

    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->
    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/app.js"></script-->
</body>
</html>
