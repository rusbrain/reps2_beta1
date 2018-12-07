<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{route('home')}}/css/bootstrap.min.css">

    <!-- font-awesome-->
    <link rel="stylesheet" href="{{route('home')}}/css/all.css">
    <!--Flags CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/flag-icon.css">
    <!--Main CSS-->
    <link rel="stylesheet" href="{{route('home')}}/css/main.css">



    <title>Главная | Reps.ru</title>
</head>
<body>
<div class="wrapper">
@inject('general_helper', 'App\Services\GeneralViewHelper')
    <!--SECTION HEADER-->
    <section>
        <div class="container">
            @include('header')
        </div>
    </section>
    <!--END SECTION HEADER-->

    <!-- SECTION NAVIGATION-->
    <section>
        <div class="container">
            <!-- MAIN NAVIGATION-->
{{--            @include('navigation')--}}
        <!-- END MAIN NAVIGATION -->
        </div>
    </section>
    <!--END SECTION NAVIGATION-->

    <!--CONTENT-->
    <section>
        <div class="container">
            <div class="row page">
                <!--LEFT SIDEBAR-->
                <div class="col-md-2">
                    @include('sidebar-left')
                </div>
                <!--END LEFT SIDEBAR -->

                <!--CONTENT CENTER-->
                <div class="col-md-8 content-center">
                    @yield('content')
                </div>
                <!--END CONTENT CENTER-->

                <!--RIGHT SIDEBAR-->
                <div class="col-md-2">
                    @include('sidebar-right')
                </div>
                <!--END RIGHT SIDEBAR-->
            </div>
        </div>
    </section>
    <!--END CONTENT-->

    <!--FOOTER-->
    <section>
        <div class="container">
            @include('footer')
        </div>
    </section>
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

<!-- CkEditor -->
<script src="{{route('home')}}/js/ckeditor/ckeditor.js"></script>
<!-- jQuery Validate -->
<script src="{{route('home')}}/js/jquery.validate.min.js"></script>

@yield('js')
<!--Custom scripts-->
<script src="{{route('home')}}/js/scripts.js"></script>
</body>
</html>