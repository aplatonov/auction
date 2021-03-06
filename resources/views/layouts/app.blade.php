@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
    @include('layouts.menu')
        <div>
            @yield('confirmregister')  
        </div>
        <div class="row"><!-- Begin Top Section -->
            <!-- lots Preview
            ================================================== -->
            @yield('carousel')

            <!-- articles Area
            ================================================== -->
            @yield('articles')
            
        </div><!-- End Top Section -->

        @yield('title')

        <!-- Gallery Items
        ================================================== --> 
        <div class="row gallery-row">
            @yield('gallery')
        </div>

    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->
    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/app.js"></script-->
</body>
</html>
