@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="panel-body">
                <div class="row">
                    <div class="span2"></div>
                    <div class="span8">
                        <h3>Обработка лотов</h3>

                        @if ($message)
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                    <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        
                        @if ($stat)
                            <p class="lead">{!! $stat !!}</p>
                        @endif
                    </div>
                    <div class="span2"></div>
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
