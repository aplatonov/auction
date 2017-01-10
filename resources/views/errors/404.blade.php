@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row">
            <div class="span3">
            </div>
            <div class="span6">
                <h5 class="title-bg">Запрашиваемая страница не найдена</h5>
                <img src="/img/404.png" alt="404 Not Found" hspace="35">
            </div>
            <div class="span3">
            </div>
        </div>

    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->
    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/app.js"></script-->
</body>
</html>
