@include('layouts.header')

    <!-- Scripts -->
    <script>
        $(document).ready(function(){
            $.fn.extend({
                treed: function (o) {
                    var openedClass = 'icon-minus-sign';
                    var closedClass = 'icon-plus-sign';

                    if (typeof o != 'undefined'){
                        if (typeof o.openedClass != 'undefined'){
                            openedClass = o.openedClass;
                        }

                        if (typeof o.closedClass != 'undefined'){
                            closedClass = o.closedClass;
                        }
                    };

                    /* initialize each of the top levels */
                    var tree = $(this);
                    tree.addClass("tree");
                    tree.find('li').has("ul").each(function () {
                        var branch = $(this);
                        branch.prepend("");
                        branch.addClass('branch');
                        branch.on('click', function (e) {
                            if (this == e.target) {
                                var icon = $(this).children('i:first');
                                icon.toggleClass(openedClass + " " + closedClass);
                                $(this).children().children().toggle();
                            }
                        })
                        branch.children().children().toggle();
                    });

                    /* fire event from the dynamically added icon */
                    tree.find('.branch .indicator').each(function(){
                        $(this).on('click', function () {
                            $(this).closest('li').click();
                        });
                    });


                    /* fire event to open branch if the li contains an anchor instead of text */
                    tree.find('.branch>a').each(function () {
                        $(this).on('click', function (e) {
                            $(this).closest('li').click();
                            e.preventDefault();
                        });
                    });

                    /* fire event to open branch if the li contains a button instead of text */
                    tree.find('.branch>button').each(function () {
                        $(this).on('click', function (e) {
                            $(this).closest('li').click();
                            e.preventDefault();
                        });
                    });
                }
            });

            /* Initialization of treeviews */
            $('#tree1').treed();
        });
    </script>


<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="panel-body">
                <div class="row">
                    <div class="span8">
                        <h3>Категории</h3>
                        <ul id="tree1" class="tree">
                            @foreach($categories as $category)
                                <li>
                                    @if(count($category->childs))
                                        <i class="indicator icon-plus-sign"></i>
                                    @else
                                        <i class="indicator icon-plus-sign icon-white"></i>
                                    @endif
                                    {{ $category->name_cat }}
                                    @if(count($category->childs))
                                        @include('manageChild',['childs' => $category->childs])
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="span4">
                        <h3>Добавление категории</h3>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                    <strong>{{ $message }}</strong>
                            </div>
                        @endif

                        <form method="POST" action="{{action('CategoryController@addCategory')}}"/>
                            <div class="form-group{{ $errors->has('name_cat') ? ' has-error' : '' }}">
                                <label for="name_cat" class="col-md-4 control-label">Название категории</label>

                                <div class="col-md-4">
                                    <input id="name_Cat" type="text" class="form-control" name="name_cat" value="{{ old('name_cat') }}" required autofocus>

                                    @if ($errors->has('name_cat'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name_cat') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <label for="parent_id" class="col-md-4 control-label">Родительская категория</label>
                            <div class="col-md-4">
                                <select id="parent_id" name="parent_id" class="form-control">
                                    <option value="0">Корневая</option>
                                    @foreach($allCategories as $category)
                                        <option value="{{$category->id}}">{{$category->name_cat}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            <input type="submit" value="Добавить">
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->

    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/treeview.js"></script-->
</body>
</html>
