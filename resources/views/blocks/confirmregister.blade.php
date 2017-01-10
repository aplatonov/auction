    @if (Auth::user() && Auth::user()['original']['confirmed'] == 0)
        <div class="row">
            <div class="span2">
            </div>
            <div class="span8">
                <h4>Завершение регистрации пользователя</h4>
                <div class="panel-body">
                    @if (Auth::user()['original']['confirmed'] == 0)
                        На указанный адрес электронной почты выслано письмо со ссылкой для подтверждения регистрации.
                        <br><br>Для отладочных целей показана <a href="{{ url('/register/confirm/' . Auth::user()['original']['confirmation_code']) }}">ссылка для подтверждения</a>. Вставьте ее в адресную строку браузера для завершения регистрации.
                    @endif
                </div>
            </div>
        </div>
    @endif