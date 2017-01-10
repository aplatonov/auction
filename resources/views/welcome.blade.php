@include('layouts.header')

<body>
    <div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>
    <div class="container">
        @include('layouts.menu')
        <div class="row"><!-- Begin Top Section -->
            <!-- lots Preview
            ================================================== -->
            @include('blocks.carousel')

            <!-- articles Area
            ================================================== -->
            @include('blocks.articles')
            
        </div><!-- End Top Section -->

    </div> <!-- End Container -->

    <!-- Footer Area
        ================================================== -->
    @include('layouts.footer')

    <!-- Scripts -->
    <!--script src="/js/app.js"></script-->
</body>
</html>
