@include('layouts.header')

    <!-- Scripts -->
    <script>
        $(document).ready(function(){
            $('#betForm').submit(function(e){
                e.preventDefault();
                /*$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });*/

                var bet_price = $('#bet_price').val();
                var user_id = $('#user_id').val();
                var lot_id = $('#lot_id').val();

                $.ajax({
                    type: 'POST',
                    url: '/bets/makebet',
                    cache: false,
                    dataType: 'json',
                    data: {bet_price: bet_price,
                           user_id: {{ Auth::id() }},
                           lot_id: lot_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        var items = [];
                        $.each(response[0], function(key, val){
                            items.push('id#' + val.id + ' ' + val.created_at +' <strong>' + val.bet_price + '</strong> от ' + val.username + '<br>');
                        });
                        $("#msg").html( (items.length == 0) ? 'Ставок не было' : items.join('') ).fadeIn();
                        if (items.length > 0) {
                            $('#winprice').html(response[0][0].bet_price).fadeIn();
                        }

                        items = [];
                        $.each(response[1], function(key, val){
                            items.push('id#' + val.id + ' ' + val.created_at +' <strong>' + val.bet_price + '</strong>' + '<br>');
                        });
                        $("#msg-user").html( (items.length == 0) ? 'Ставок не было' : items.join('') ).fadeIn();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#msg").html(jqXHR.responseText).fadeIn();
                    }

                });
                return false;
            });

            $('.changePayStatus').submit(function(e){
                e.preventDefault();
                
                var lot_id = $(this).find("input[name=lot_id]").val();
                var pay_status_id = $(this).find("select[name=pay_status_id]").val();

                $.ajax({
                    type: 'POST',
                    url: '/lots/paystatus/' + lot_id,
                    cache: false,
                    dataType: 'json',
                    data: {lot_id: lot_id,
                           pay_status_id: pay_status_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            console.log("#pay_status_id"+lot_id+" "+pay_status_id);
                        } else {
                            console.log(response.text + ' Не удалось изменить статус оплаты.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka payStatus');
                    }
                });
                return false;
            });                 
        });

        function getBets() {
            var timerId = setTimeout(function tick() {
                var lot_id = $('#lot_id').val();

                $.ajax({
                    type: 'POST',
                    url: '/bets/makebet',
                    cache: false,
                    dataType: 'json',
                    data: {bet_price: '',
                           user_id: {{ Auth::id() }}, 
                           lot_id: lot_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {

                        var items = [];
                        $.each(response[0], function(key, val){
                            items.push('id#' + val.id + ' ' + val.created_at +' <strong>' + val.bet_price + '</strong> от ' + val.username + '<br>');
                        });
                        $("#msg").html( (items.length == 0) ? 'Ставок не было' : items.join('') ).fadeIn();
                        if (items.length > 0) {
                            $('#winprice').html(response[0][0].bet_price).fadeIn();
                        }

                        items = [];
                        $.each(response[1], function(key, val){
                            items.push('id#' + val.id + ' ' + val.created_at +' <strong>' + val.bet_price + '</strong>' + '<br>');
                        });
                        $("#msg-user").html( (items.length == 0) ? 'Ставок не было' : items.join('') ).fadeIn();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $("#msg").html(jqXHR.responseText).fadeIn();
                    }

                });
                timerId = setTimeout(tick, 5000);
            }, 5000);
        }        
    </script>


<body onLoad = "getBets()">
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="span12 gallery-single">

                <div class="row">
                    <div class="span6">
                        <h6 class="title-bg">Лот #{{ $lot->id }}: <small>{{ $lot->lot_name }}</small></h6>
                        <div class="flexslider">
                          <ul class="slides">
                                  @foreach ($lot->images as $images)
                                       @if ( $images != '' ) 
                                            <li><a href="../img/gallery/{{ $lot->id }}/{{ $images }}" class="lightbox" data-rel="prettyPhoto" rel="prettyPhoto" title="{{ $lot->lot_name }}"><img src="../img/gallery/{{ $lot->id }}/{{ $images }}" alt="{{ $images }}" class="align-left blog-thumb-preview" /></a></li>
                                       @else
                                            <li><a href="../img/noimage.png" class="lightbox" data-rel="prettyPhoto" rel="prettyPhoto" title="{{ $lot->lot_name }}"><img src="../img/noimage.png" alt="no image" class="align-left blog-thumb-preview" /></a></li>
                                       @endif 
                                  @endforeach
                          </ul>
                        </div>
                    </div>
                    <div class="span6">
                        <h2>{{ $lot->lot_name }}</h2>
                        <p class="lead"></p>
                        <p>{{ $lot->description }}</p>

                        <ul class="project-info">
                            <li><h6>Категория: </h6><strong>{{ $category }}</strong></li>
                            <li><h6>Стартовая цена: </h6><strong>{{ $lot->start_price }}</strong></li>
                            <li><h6>Разместивший пользователь: </h6><strong>{{ $owner }}</strong></li>
                            <li><h6>Начало аукциона: </h6><strong>{{ $lot->begin_auction }}</strong></li>
                            <li><h6>Окончание аукциона: </h6><strong>{{ $lot->end_auction }}</strong></li>
                            <li><h6>Блокировка: </h6><strong>{{ $disable }}</strong></li>
                            <li><h6>Окончательная <small>(побеждающая)</small> цена: </h6><strong><span id="winprice">{{ $final_price }}</span></strong></li>
                            <li><h6>Покупатель: </h6><strong>{{ $winner }}</strong></li>
                            <li><h6>Статус оплаты: </h6><strong>
                                @if (Auth::id() == $lot->owner_id && $lot->disable_reason_id == 3)
                                    <form class="changePayStatus" > 
                                        <br>
                                        <select id="pay_status_id" name="pay_status_id" class="form-control pull-left">
                                            @foreach($pay_status_arr as $pay_status)
                                                @if ($lot->pay_status_id == $pay_status->id)
                                                    <option selected value="{{$pay_status->id}}">{{$pay_status->pay_descr}}</option>
                                                @else
                                                    <option value="{{$pay_status->id}}">{{$pay_status->pay_descr}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="lot_id" id="lot_id" value="{{ $lot->id }}"/>
                                        <input class="btn btn-small pull-right" type="submit" name="action" value="Применить">
                                        <br>
                                    </form>                                    
                                @elseif (Auth::check())
                                    {{ $pay_status }}
                                @endif
                            </strong></li>
                        </ul>

                        @if (Auth::id() == $lot->owner_id )
                            <form method="POST" action="{{action('LotController@destroy',['lot'=>$lot->id])}}">
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}"/>
                                <input type="hidden" name="lot_id" id="lot_id" value="{{ $lot->id }}"/>
                                <input type="submit" class="btn btn-inverse pull-left" value="Удалить"/>
                            </form>

                            <a href="{{ url('/lots/'.$lot->id.'/edit') }}"><button class="btn pull-right" type="button">Редактировать</button></a>
                            <br><br>
                            <div class="span4"><h6>Максимальные ставки</h6>
                                <p class="well well-small" id="msg"><img src="/img/ajax-loader.gif" alt="Загрузка..." /><br>
                                </p>
                            </div>
                        @elseif (Auth::check())
                            <div class="span2">
                                    <form class="form-search" id="betForm">
                                    @if ($lot->disable_reason_id == 0) 
                                        <div class="input-prepend">
                                            <input class="btn btn-inverse" type="submit" value="Моя ставка">
                                            <input class="span1 search-query" type="text" name="bet_price" id="bet_price" onkeyup="this.value = this.value.replace (/\D/g, '')"/>
                                        </div>
                                    @endif
                                        <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}"/>
                                        <input type="hidden" name="lot_id" id="lot_id" value="{{ $lot->id }}"/>
                                     </form>
                                 <h6>Ваши ставки</h6>
                                 <p class="well well-small" id="msg-user"><img src="/img/ajax-loader.gif" alt="Загрузка..." /><br></p>
                             </div>

                            <div class="span3 pull-right"><h6>Максимальные ставки</h6>
                                <p class="well well-small" id="msg"><img src="/img/ajax-loader.gif" alt="Загрузка..." /><br>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- End gallery-single-->
        </div>
    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->

    @include('layouts.footer')

</body>
</html>
