    <div class="footer-container"><!-- Begin Footer -->
        <div class="container">
            <div class="row footer-row">
                <div class="span2 footer-col">
                    <h5>О проекте</h5>
                   <img src="/img/auction-footer-logo.png" alt="Auction logo" /><br /><br />
                    <address>
                        <strong>Итоговое задание</strong><br />
                        курс "Продвинутый PHP"<br />
                        компании <a href="{{asset('http://php73.ru')}}">Mediasoft</a><br />
                        автор Платонов А.В.<br />
                        2016 г.<br />
                        <a href="{{asset('https://github.com/aplatonov/auction')}}">Проект на GitHub</a><br />
                    </address>
                </div>
                <div class="span3 footer-col">
                    <h5>Инструменты</h5>
                    <ul>
                        <li><a href="{{asset('http://php.net/')}}">PHP</a> version 5.6.28</li>
                        <li><a href="{{asset('http://www.mysql.com/')}}">MySQL</a> version 5.5.53</li>         
                        <li><a href="{{asset('https://laravel.com/')}}">Laravel framework</a> version 5.3</li>
                        <li><a href="{{asset('http://ubuntu.ru/get')}}">Ubuntu</a> version 14.04.5 LTS Trusty Tahr</li>
                        <li><a href="{{asset('/')}}">Piccolo Theme</a> free responsive standalone HTML template using Bootstrap</li>
                    </ul>
                </div>    
                <div class="span1 footer-col">
                </div>            
                <div class="span3 footer-col">
                    @include('blocks.lastlots')
                </div>
                <div class="span3 footer-col">
                    @include('blocks.lotspics')
                </div>
            </div>

            <div class="row"><!-- Begin Sub Footer -->
                <div class="span12 footer-col footer-sub">
                    <div class="row no-margin">
                        <div class="span6"><span class="left">Copyleft 2016 Platonov A. All rights not reserved.</span></div>
                        <div class="span6">
                            <span class="right">
                            <a href="{{asset('/')}}">Главная</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{asset('/home')}}">Действующие лоты</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{asset('/blockedlots')}}">Разыгранные лоты</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                            <a href="{{asset('/contacts')}}">Контакты</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- End Sub Footer -->

        </div>
    </div><!-- End Footer --> 