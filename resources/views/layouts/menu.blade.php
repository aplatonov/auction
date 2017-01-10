        <div class="row header"> <!-- Header -->
            <div class="span2 logo">
                <a href="{{ url('/') }}"><img src="/img/auction-logo.png" alt="{{ config('app.name', 'auction') }}" /></a>
            </div>
            <div class="span3">
            </div>
            <div class="span7 navigation"> <!-- Top menu -->
                <div class="navbar-header">
                    <div class="navbar">
                       <ul class="nav">
                            @if (!Auth::guest() && Auth::user()->role_id == 1)
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Меню админа<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/admin/users') }}">Пользователи</a></li>
                                        <li><a href="{{ url('/admin/lots') }}">Лоты</a></li>
                                        <li><a href="{{ url('/admin/categories') }}">Категории</a></li>
                                        <li><a href="{{ url('/admin/checklots') }}">Проверить окончание торгов</a></li>
                                    </ul>
                                </li>    
                            @endif
                            @if (!Auth::guest())
                                <li class="dropdown active">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Меню <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/') }}">На главную</a></li>
                                        <li><a href="{{ url('/home') }}">Действующие лоты</a></li>
                                        <li><a href="{{ url('/blockedlots') }}">Разыгранные лоты</a></li>
                                    </ul>
                                </li>    
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/home') }}">Категории<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        @foreach($categories as $category)
                                            @if(count($category->childs))
                                                <li class="dropdown-submenu">
                                                    <a class="dropdown-toggle" href="{{ url('/category/' . $category->id ) }}">{{ $category->name_cat }} [{{ count($category->lots) }}]</a>
                                                    @include('manageChildMenu',['childs' => $category->childs])
                                                </li>
                                            @else
                                                <li><a href="{{ url('/category/' . $category->id ) }}">{{ $category->name_cat }} [{{ count($category->lots) }}]</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ url('/') }}">Мой аукцион<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/lots/create') }}">Новый лот</a></li>
                                        <li><a href="{{ url('/userlots') }}">Мои лоты</a></li>
                                        <li><a href="{{ url('/userwinlots') }}">Мои выигранные лоты</a></li>
                                    </ul>
                                </li>
                            @endif

                            <li><a href="{{ url('/contacts') }}">Контакты</a></li>
                            @if (Auth::guest())
                                <li class="active"><a href="{{ url('/login') }}">Вход</a></li>
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
            @include('blocks.info')
            @yield('content')
        </div> <!-- End Header -->