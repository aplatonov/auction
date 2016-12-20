        <div class="row header"> <!-- Header -->
            <div class="span2 logo">
                <a href="{{ url('/') }}"><img src="../img/auction-logo.png" alt="{{ config('app.name', 'auction') }}" /></a>
            </div>
            <div class="span3">
            </div>
            <div class="span7 navigation"> <!-- Top menu -->
                <div class="navbar-header">
                    <div class="navbar">
                       <ul class="nav">
                            <li class="dropdown active">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Меню <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/') }}">На главную</a></li>
                                    <li><a href="{{ url('/home') }}">Список лотов</a></li>
                                    <li><a href="{{ url('/') }}">Горячие предложения</a></li>
                                </ul>
                            </li>
                            @if (!Auth::guest())
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Мой аукцион<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/lots/create') }}">Новый лот</a></li>
                                    <li><a href="{{ url('/userlots') }}">Мои лоты</a></li>
                                    <li><a href="{{ url('/') }}">Настройки</a></li>
                                </ul>
                            </li>
                            @endif
                            <li><a href="{{ url('/contacts') }}">Контакты</a></li>
                            @if (Auth::guest())
                                <li><a href="{{ url('/login') }}">Вход</a></li>
                                <li><a href="{{ url('/register') }}">Регистрация</a></li>
                            @else
                                <li>
                                    <a href="{{ url('/logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Выход</a>
                                    <form id="logout-form" action="{{ url('/logout') }}" 
                                        method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div> <!-- End Top menu -->
            @yield('content')
        </div> <!-- End Header -->