@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="span12 gallery-single">
                <div class="row">
                    <div class="span2">
                    </div>
                    <form method="POST" enctype="multipart/form-data" action="{{action('LotController@update', ['lot'=>$lot->id])}}"/>
                        <div class="span4">
                            <div class="form-group{{ $errors->has('lot_name') ? ' has-error' : '' }}">
                                <label for="lot_name" class="col-md-4 control-label">Название лота</label>

                                <div class="col-md-4">
                                    <input id="lot_name" type="text" class="form-control" name="lot_name" value="{{ $lot->lot_name }}" required autofocus {{ $readonly }}>

                                    @if ($errors->has('lot_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('lot_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Описание лота</label>

                                <div class="col-md-4">
                                    <textarea id="description" type="text" class="form-control" name="description" required>{{ $lot->description }}</textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="category_id" class="col-md-4 control-label">Категория лота</label>
                                <div class="col-md-4">
                                    <select id="category_id" name="category_id" class="form-control">
                                        @foreach($allCategories as $category)
                                            @if ($lot->category_id == $category->id)
                                                <option selected value="{{$category->id}}">{{$category->name_cat}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name_cat}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('start_price') ? ' has-error' : '' }}">
                                <label for="start_price" class="col-md-4 control-label">Стартовая цена</label>

                                <div class="col-md-4">
                                    <input id="start_price" type="text" class="form-control" name="start_price" value="{{ $lot->start_price }}" required autofocus {{ $readonly }}>

                                    @if ($errors->has('start_price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('start_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('begin_auction') ? ' has-error' : '' }}">
                                <label for="begin_auction" class="col-md-4 control-label">Начало торга по лоту</label>

                                <div class="col-md-4">
                                    <input id="begin_auction" type="text" class="form-control" name="begin_auction" value="{{ $lot->begin_auction }}" required>

                                    @if ($errors->has('begin_auction'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('begin_auction') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('begin_auction') ? ' has-error' : '' }}">
                                <label for="end_auction" class="col-md-4 control-label">Окончание торга по лоту</label>

                                <div class="col-md-4">
                                    <input id="end_auction" type="text" class="form-control" name="end_auction" value="{{ $lot->end_auction }}" required>

                                    @if ($errors->has('end_auction'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('end_auction') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>                                                

                            <script type="text/javascript">
                                $(function(){
                                    $('*[name=begin_auction]').appendDtpicker({
                                        "closeOnSelected": true,
                                        "minuteInterval": 15,
                                        "locale": "ru",
                                        "firstDayOfWeek": 1,
                                        "futureOnly": true,
                                        "dateFormat": "YYYY-MM-DD hh:mm"
                                    });
                                    $('*[name=end_auction]').appendDtpicker({
                                        "closeOnSelected": true,
                                        "minuteInterval": 15,
                                        "locale": "ru",
                                        "firstDayOfWeek": 1,
                                        "futureOnly": true,
                                        "dateFormat": "YYYY-MM-DD hh:mm"
                                    });
                                });
                            </script>

                            <div class="col-md-4">
                                <label for="disabled" class="col-md-4 control-label">Заблокирован</label>
                                <input type="checkbox" {{ $lot->disabled ? 'checked' : ''}} class="form-control" name="disabled" value="0"><br>
                            </div>
                            <br>                      

                        </div>
                        <div class="span4">
                            @if (!empty($old_images))
                                <div class="col-md-4">
                                    <table class="table table-condensed">
                                    <tr>
                                    <td>Оставить</td>
                                    <td>Старые изображения</td>
                                    </tr>

                                    @foreach($old_images as $old_image)
                                       <tr> 
                                        <td><input type="checkbox" checked class="form-control" name="old_img[]" value="{{ $old_image }}"></td>
                                        <td><img src="/img/gallery/{{ $lot->id }}/{{ $old_image }}" alt="{{ $old_image }}" class="align-left admin-thumb-preview-img" /></td>
                                        </tr>
                                    @endforeach
                                    </table>
                                </div>
                                <br>
                            @endif

                            <div class="form-group{{ $errors->has('images') ? ' has-error' : '' }}">
                                <label for="images" class="col-md-4 control-label">Новые изображения</label>

                                <div class="col-md-4">
                                    <input id="images" type="file" multiple class="form-control" name="images[]" value="{{ $lot->images }}" accept="image/*">

                                    @if ($errors->has('images'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('images') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>    

                            <br>                        
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="hidden" name="_method" value="put">
                            <input type="submit" value="Сохранить">
                        </div>
                    </form>
                    <div class="span2">
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
