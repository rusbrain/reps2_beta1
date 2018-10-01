<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- font-awesome-->
    <link rel="stylesheet" href="/css/all.css">
    <!--Main CSS-->
    <link rel="stylesheet" href="/css/main.css">

    <title>Главная | Reps.ru</title>
</head>
<body>
<div class="wrapper">

    <!--SECTION HEADER-->
    <section>
        <div class="container">
            @yield('header')
        </div>
    </section>
    <!--END SECTION HEADER-->

    <!-- SECTION NAVIGATION-->
    <section>
        <div class="container">
            <!-- MAIN NAVIGATION-->
            @yield('navigation')
            <!-- END MAIN NAVIGATION -->
        </div>
    </section>
    <!--END SECTION NAVIGATION-->

    <!--CONTENT-->
    <section>
        <div class="container">
            <div class="row">
                <!--LEFT SIDEBAR-->
                @yield('sidebar-left')
                <!--END SIDEBAR -->

                <!--CONTENT CENTER-->
                @yield('content')
                <!--END CONTENT CENTER-->

                <!--RIGHT SIDEBAR-->
                @yield('sidebar-right')
                <!--END RIGHT SIDEBAR-->
            </div>
        </div>
    </section>
    <!--END CONTENT-->

    <!--FOOTER-->
    <section>
        <div class="container">
            @yield('footer')
        </div>
    </section>
    <!--END FOOTER-->

</div><!--close div /.wrapper-->


<!-- ========ALL MODAL WINDOWS ============== -->

<!-- ========== END ALL MODAL WINDOWS ============ -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>

<!-- jQuery Validate -->
<script src="/js/jquery.validate.min.js"></script>

<!--Custom scripts-->
<script src="/js/scripts.js"></script>
</body>
</html>