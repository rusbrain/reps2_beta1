<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{route('home')}}/css/bootstrap.min.css">

    <!--Flags CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/flag-icon.css">

    <!--Menu-->
    <link rel="stylesheet" href="{{route('home')}}/css/metisMenu.min.css">

    <!--CSS into View-->
    @yield('css')

    <!--Main CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/main.css">
    <link rel="stylesheet" href="{{route('home')}}/css/responsive.css">
    <title>Главная | Reps.ru</title>
</head>
<body>
@inject('general_helper', 'App\Services\GeneralViewHelper')
<div class="wrapper">
    <!--SECTION HEADER-->
    <section class="section-header">
        <div class="container">
            @include('header')
        </div>
    </section>
    <!--END SECTION HEADER-->

    <!--SECTION CONTENT-->
    <section>
        <div class="container">
            <div class="row">
                <!--SIDEBAR LEFT-->
                <div class="col-md-3">
                    <div class="sidebar-wrapper">
                        <!--Navigation-->
                        @include('layouts.partials.navigation')
                        <!--END Navigation-->

                        @yield('sidebar-left')

                    </div><!-- close div /.left-sidebar-wrapper-->
                </div>
                <!--END SIDEBAR LEFT-->

                <!--CONTENT-->
                <div class="col-md-6">
                    @yield('content')
                </div>
                <!--END CONTENT-->

                <!--SIDEBAR RIGHT-->
                <div class="col-md-3">
                    <div class="sidebar-wrapper">
                        @yield('sidebar-right')
                    </div>
                </div>
                <!--END SIDEBAR RIGHT-->
            </div>
        </div>
    </section>
    <!--END SECTION CONTENT-->

    <!--FOOTER-->
    @include('footer')
    <!--END FOOTER-->

</div><!--close div /.wrapper-->

<!-- ========ALL MODAL WINDOWS ============== -->

<!-- ========== END ALL MODAL WINDOWS ============ -->

<!-- Optional JavaScript -->
<script src="{{route('home')}}/js/jquery-3.2.1.min.js"></script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{route('home')}}/js/popper.min.js"></script>
<script src="{{route('home')}}/js/bootstrap.min.js"></script>
<script src="{{route('home')}}/js/bootstrap-filestyle.min.js"></script>

<!--Menu js-->
<script src="{{route('home')}}/js/metisMenu.min.js"></script>
<!-- jQuery Validate -->
<script src="{{route('home')}}/js/jquery.validate.min.js"></script>



<!--js into View-->
@yield('js')
<!--Custom scripts-->
<script src="{{route('home')}}/js/scripts.js"></script>
</body>
</html>