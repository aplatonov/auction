@include('layouts.header')

    <!-- Scripts -->
    <script>
        $(document).ready(function(){
            $('.confirmUser').submit(function(e){
                e.preventDefault();

                var user_id = $(this).find("input[name=user_id]").val();
    
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/confirm/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            $("#confirmedUser"+user_id).html('да');
                        } else {
                            console.log(response.text + ' Не хватает прав для подтверждения пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
                    }

                });
                return false;
            });

            $('.blockUser').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var user_id = $(this).find("input[name=user_id]").val();
                if (action == 'Заблокировать') {
                    action = 0;
                } else {
                    action = 1;
                }
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/block/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 0) {
                                document.getElementById("blockedUser"+user_id).value = "Разблокировать";   
                            } else {
                                document.getElementById("blockedUser"+user_id).value = "Заблокировать";
                            }
                            
                            console.log("#blockedUser"+user_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для блокировки/разблокировки пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
                    }
                });
                return false;
            });            

            $('.adminUser').submit(function(e){
                e.preventDefault();
                var action = $(this).find("input[name=action]").val();
                var user_id = $(this).find("input[name=user_id]").val();
                if (action == 'Администратор') {
                    action = 1;
                } else {
                    action = 2;
                }
                console.log(action+'-'+user_id);
                $.ajax({
                    type: 'POST',
                    url: '/admin/users/role/' + user_id,
                    cache: false,
                    dataType: 'json',
                    data: {user_id: user_id,
                           action: action,
                           '_token': "{{csrf_token()}}"
                    },
                    success: function (response) {
                        if (response.text == 'success') {
                            if (action == 1) {
                                document.getElementById("adminedUser"+user_id).value = "Пользователь";   
                            } else {
                                document.getElementById("adminedUser"+user_id).value = "Администратор";
                            }
                            
                            console.log("#adminedUser"+user_id);
                        } else {
                            console.log(response.text + ' Не хватает прав для изменения роли пользователя.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('oshibka');
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
                <div class="row label"><h4>Пользователи</h4>
                </div>
                <div class="no-margin pager">
                    {{ $users->links('vendor.pagination.default') }}
                </div>
                
                @if( session()->has('message'))
                    <div class="alert alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session()->get('message') }}</strong> 
                    </div>
                @endif
                
                <div class="row">
                    <div class="span2">
                    </div>
                     <div class="span8">
                        <table class="table table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Login</th>
                            <th>Имя</th>
                            <th>e-mail</th>
                            <th>Дать роль</th>
                            <th>Подтвержден</th>
                            <th>Блокировка</th>
                            <th>Удалить</th>
                        </tr>

                        @foreach($users as $user)
                            <tr> 
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->surname }}&nbsp;{{ $user->firstname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->role_id == 1)
                                        <div id="adminUser{{ $user->id }}">
                                            <form class="adminUser" > 
                                                <input class="btn btn-mini" type="submit" name="action" id="adminedUser{{ $user->id }}" value="Пользователь">
                                                <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                            </form>
                                        </div>
                                    @else
                                        <div id="adminUser{{ $user->id }}">
                                            <form class="adminUser" > 
                                                <input class="btn btn-mini" type="submit" name="action" id="adminedUser{{ $user->id }}" value="Администратор">
                                                <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                            </form>
                                        </div>
                                    @endif                                
                                </td>
                                <td>
                                    @if (!$user->confirmed)
                                        <div id="confirmedUser{{ $user->id }}">
                                            <form class="confirmUser" > 
                                                <input class="btn btn-mini btn-warning" type="submit" value="Подтвердить">
                                                <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                            </form>
                                        </div>
                                    @else
                                        <div>да</div>
                                    @endif
                                </td>

                                <td>
                                    @if ($user->valid)
                                        <div id="blockUser{{ $user->id }}">
                                            <form class="blockUser" > 
                                                <input class="btn btn-mini" type="submit" name="action" id="blockedUser{{ $user->id }}" value="Заблокировать">
                                                <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                            </form>
                                        </div>
                                    @else
                                        <div id="blockUser{{ $user->id }}">
                                            <form class="blockUser" > 
                                                <input class="btn btn-mini" type="submit" name="action" id="blockedUser{{ $user->id }}" value="Разблокировать">
                                                <input type="hidden" name="_token"  id="_token" value="{{csrf_token()}}"/>
                                                <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}"/>
                                            </form>
                                        </div>
                                    @endif
                                <td>
                                    <form method="POST" action="{{action('AdminController@destroyUser',['id'=>$user->id])}}">
                                        <input type="hidden" name="_method" value="delete"/>
                                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                                        <input type="submit" class="btn btn-mini btn-inverse" value="Удалить"/>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
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
