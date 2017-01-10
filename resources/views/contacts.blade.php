@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row"><!-- Begin Top Section -->

        <div class="span8 contact"><!--Begin page content column-->

            <h2>Есть вопрос? Напишите нам</h2>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                </div>
            @endif

            <form action="{{action('EmailController@send')}}" method="POST" id="contact-form" class="contact-form" role="form">
                <div for="name" class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input class="span4" id="prependedInput" size="16" type="text" name="name" placeholder="Ваше имя" 
                        @if (Auth::guest())
                            value="{{ old('name') }}"
                        @else
                            value="{{ Auth::user()->firstname }} {{Auth::user()->secondname }} ({{ Auth::user()->username }})"
                        @endif
                         required>
                    </div>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div for="email" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input class="span4" id="prependedInput" size="16" type="text" name="email" placeholder="e-mail" 
                        @if (Auth::guest())
                            value="{{ old('email') }}"
                        @else
                            value="{{ Auth::user()->email }}"
                        @endif
                         required>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif                    
                </div>

                <div for="user_message" class="form-group{{ $errors->has('user_message') ? ' has-error' : '' }}">
                    <textarea class="span7" name="user_message" required>{{ old('user_message') }}</textarea>
                    @if ($errors->has('user_message'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_message') }}</strong>
                        </span>
                    @endif                       
                </div>

                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="row">
                    <div class="span2">
                        <input type="submit" class="btn btn-inverse" value="Отправить сообщение">
                    </div>
                </div>
            </form>

        </div> <!--End page content column-->

        <!-- Sidebar
        ================================================== --> 
        <div class="span4 sidebar page-sidebar"><!-- Begin sidebar column -->
            <h5 class="title-bg">Наш адрес</h5>
            <address>
            <strong>Ульяновск</strong><br>
            432000<br>
            ул. Федерации, 85А<br>
            <abbr title="Телефон">Тел:</abbr> (8422) 456-7890
            </address>
             
            <address>
            <strong>Администратор</strong><br>
            <a href="mailto:admin@auction.ru">admin@auction.ru</a>
            </address>

            <h5 class="title-bg">Как добраться</h5>
            <div id="map">
            </div>

        </div><!-- End sidebar column -->

        </div><!-- End Top Section -->

    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->
    @include('layouts.footer')

    <!-- Scripts -->

</body>
</html>
