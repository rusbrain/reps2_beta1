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
    <!--Flags CSS-->
    <link rel="stylesheet" href="/css/flag-icon.css">
    <!--Main CSS-->
    <link rel="stylesheet" href="/css/main.css">

    <script src="/js/jquery-3.2.1.min.js"></script>
    <!-- CkEditor -->
    <script src="/js/ckeditor/ckeditor.js"></script>

    <title>Главная | Reps.ru</title>
</head>
<body>
<div class="wrapper">

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
            @include('navigation')
        <!-- END MAIN NAVIGATION -->
        </div>
    </section>
    <!--END SECTION NAVIGATION-->

    <!--CONTENT-->
    <section>
        <div class="container">
            <div class="row page">
                <!--LEFT SIDEBAR-->
                <div class="col">
                    @include('sidebar-left')
                </div>
                <!--END LEFT SIDEBAR -->

                <!--CONTENT CENTER-->
                <div class="col-md-7 content-center">
                    @yield('content')
                </div>
                <!--END CONTENT CENTER-->

                <!--RIGHT SIDEBAR-->
                <div class="col">
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
            @section('footer')
                @include('footer')
            @endsection
        </div>
    </section>
    <!--END FOOTER-->

</div><!--close div /.wrapper-->

<!-- ========ALL MODAL WINDOWS ============== -->

<!-- ========== END ALL MODAL WINDOWS ============ -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-filestyle.min.js"></script>

<!-- jQuery Validate -->
<script src="/js/jquery.validate.min.js"></script>

<!--Custom scripts-->
<script src="/js/scripts.js"></script>
</body>
</html>