<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'auction') }}</title>

    <!-- Styles -->
    <!--link href="/css/app.css" rel="stylesheet"-->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Comfortaa:300,400,700&amp;subset=cyrillic')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap-responsive.css')}}" />
    <link rel="stylesheet" href="{{asset('css/prettyPhoto.css')}}" />
    <link rel="stylesheet" href="{{asset('css/flexslider.css')}}" />
    <link rel="stylesheet" href="{{asset('css/custom-styles.css')}}" />
    <link rel="stylesheet" href="{{asset('css/jquery.simple-dtpicker.css')}}" />


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <link rel="stylesheet" href="css/style-ie.css"/>
    <![endif]-->     

    <!-- Scripts -->
    <script src="{{asset('js/jquery-1.8.3.min.js')}}"></script>
    <!--script src="{{asset('http://code.jquery.com/jquery-1.8.3.min.js')}}"></script-->
    <!--script src="{{asset('http://code.jquery.com/jquery-1.12.4.min.js')}}"></script-->
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('js/jquery.flexslider.js')}}"></script>
    <script src="{{asset('js/jquery.custom.js')}}"></script>
    <script src="{{asset('js/jquery.simple-dtpicker.js')}}"></script>
    <!--script src="{{asset('http://api-maps.yandex.ru/2.1/?lang=ru_RU')}}"></script-->
    <!--script src="{{asset('js/ymaps.js')}}"></script-->

    <script>
        window.auction = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <script>
        $(document).ready(function () {
            $("#btn-blog-next").click(function () {
              $('#blogCarousel').carousel('next')
            });
             $("#btn-blog-prev").click(function () {
              $('#blogCarousel').carousel('prev')
            });

             $("#btn-client-next").click(function () {
              $('#clientCarousel').carousel('next')
            });
             $("#btn-client-prev").click(function () {
              $('#clientCarousel').carousel('prev')
        });
    });
    </script> 

    <script> 
        $(window).load(function(){
            $('.flexslider').flexslider({
                animation: "slide",
                slideshow: true,
                start: function(slider){
                  $('body').removeClass('loading');
                }
            });  
        });
    </script>     
</head>