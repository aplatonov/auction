@include('layouts.header')

    <!-- Scripts -->
    <script>
        $(document).ready(function(){
            $('.blockLot').submit(function(e){
                e.preventDefault();
                
                var lot_id = $(this).find("input[name=lot_id]").val();
                var disable_reason_id = $(this).find("select[name=disable_reason_id]").val();

                $.ajax({
                    type: 'POST',
                    url: '/admin/lots/block/' + lot_id,
                    cache: false,
                    dataType: 'json',
                    data: {lot_id: lot_id,
                           disable_reason_id: disable_reason_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            console.log("#blockedLot"+lot_id+" "+disable_reason_id+' dt:'+response.new_date);
                            $("#blockedLot"+lot_id).html(response.new_date);
                        } else {
                            console.log(response.text + ' Не хватает прав для изменения статуса блокировки пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka blockLot');
                    }
                });
                return false;
            });              
        });
    </script>

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="span12 gallery-single">
                <!-- Pagination -->
                <div class="row label"><h4>Лоты</h4>
                </div>

                <div class="no-margin pager">
                    {!! $data['lots']->appends($data['page_appends'])->links('vendor.pagination.default') !!}
                </div>
                
                @if( session()->has('message'))
                    <div class="alert alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session()->get('message') }}</strong> 
                    </div>
                @endif
                                
                <div class="row">
                     <div class="span12">
                        <table class="table table-striped">
                            <head>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">ID</a>{!! $data['page_appends']['order'] == 'id' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=lot_name&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Название</a>{!! $data['page_appends']['order'] == 'lot_name' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=name_cat&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Категория</a>{!! $data['page_appends']['order'] == 'name_cat' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=start_price&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Стартовая цена</a>{!! $data['page_appends']['order'] == 'start_price' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=owner_id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Хозяин</a>{!! $data['page_appends']['order'] == 'owner_id' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=begin_auction&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Начало аукциона</a>{!! $data['page_appends']['order'] == 'begin_auction' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=end_auction&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Окончание аукциона</a>{!! $data['page_appends']['order'] == 'end_auction' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=final_price&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Итоговая цена</a>{!! $data['page_appends']['order'] == 'final_price' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=winner_id&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Победитель</a>{!! $data['page_appends']['order'] == 'winner_id' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th>Статус оплаты</th>
                                <th><a href="/admin/lots?page={{ $data['lots']->currentPage() }}&order=disabled_date&dir={{ $data['dir'] ? $data['dir'] : 'asc' }}">Блокировка</a>{!! $data['page_appends']['order'] == 'disabled_date' ? $data['dir'] == 'desc' ? '<i class="icon-arrow-down"</i>' : '<i class="icon-arrow-up"</i>' : '' !!}</th>
                                <th>Удалить</th>
                            </thead>

                        @foreach($data['lots'] as $lot)
                            <tr> 
                                <td>{{ $lot->id }}</td>
                                <td>{{ $lot->lot_name }}</td>
                                <td>{{ $lot->name_cat }}</td>
                                <td>{{ $lot->start_price }}</td>
                                <td>{{ $lot->owner_id }}</td>
                                <td>{{ $lot->begin_auction }}</td>
                                <td>{{ $lot->end_auction }}</td>
                                <td>{{ $lot->final_price }}</td>
                                <td>{{ $lot->winner_id }}</td>
                                <td>{{ $lot->pay_status_id }}</td>
                                <td>
                                    <div>
                                        <div id="blockedLot{{ $lot->id }}">
                                            {{ $lot->disabled_date }}
                                        </div>
                                        <form class="blockLot" > 
                                            <select id="disable_reason_id" name="disable_reason_id" class="form-control">
                                            <option {{ $lot->disable_reason_id == 0 ? 'selected' : '' }} value="0">Разблокирован</option>
                                                @foreach($data['block_reasons'] as $block_reason)
                                                    @if ($lot->disable_reason_id == $block_reason->id)
                                                        <option selected value="{{$block_reason->id}}">{{$block_reason->block_descr}}</option>
                                                    @else
                                                        <option value="{{$block_reason->id}}">{{$block_reason->block_descr}}
                                                    @endif
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                            <input type="hidden" name="lot_id" id="lot_id" value="{{ $lot->id }}"/>                  <input class="btn btn-mini" type="submit" name="action" value="Применить">
                                        </form>
                                    </div>
                                </td>
                                <td>
                                    <form method="POST" action="{{action('AdminController@deleteLot',['id'=>$lot->id])}}">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                        <input type="submit" class="btn btn-mini btn-inverse" value="Удалить"/>
                                    </form>              
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div><!-- End gallery-single-->
        </div>
    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->

    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/app.js"></script-->
</body>
</html>
