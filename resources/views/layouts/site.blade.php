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
    @yield('js')

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
                </div><!-- close div /.col-md-3-->
                <!--END SIDEBAR LEFT-->

                <!--CONTENT-->
                <div class="col-md-6">
                    <!--Last News-->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="content-box-title">Последние новости</h1>
                            </div>
                            <div class="col-md-6 margin-top-20">
                                <a href="">
                                    <img src="images/forum-topic-image-1-big.png" class="content-box-topic-img" alt="">
                                </a>
                                <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 margin-top-20">
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-1-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-2-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-3-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-4-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <!--END Last News-->

                    <!--Last Forums-->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="content-box-title">Последние форумы</h1>
                            </div>
                            <div class="col-md-6">
                                <a href="">
                                    <img src="images/forum-topic-image-2-big.png" class="content-box-forum-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box-topic-desc padding-top-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->

                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="">
                                    <img src="images/forum-topic-image-3-big.png" class="content-box-forum-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box-topic-desc padding-top-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="">
                                    <img src="images/forum-topic-image-4-big.png" class="content-box-forum-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box-topic-desc padding-top-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="">
                                    <img src="images/forum-topic-image-1-big.png" class="content-box-forum-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box-topic-desc padding-top-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="">
                                    <img src="images/forum-topic-image-5-big.png" class="content-box-forum-img" alt="">
                                </a>
                            </div>
                            <div class="col-md-6">
                                <div class="content-box-topic-desc padding-top-10">
                                    <a href="">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <!--END Last Forums-->

                    <!--Popular Forums-->
                    <div class="content-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="content-box-title">Популярные форумы</h1>
                            </div>
                            <div class="col-md-6 margin-top-20">
                                <a href="">
                                    <img src="images/forum-topic-image-6-big.png"
                                         class="content-box-topic-img" alt="">
                                </a>
                                <div class="content-box-topic-desc padding-left-15 margin-bottom-10">
                                    <a href="#">
                                        <h2 class="margin-bottom-10">Название топика - 1</h2>
                                    </a>
                                    <p class="content-box-topic-extract">
                                        Far far away, behind the word mountains, far from the countries Vokalia and
                                        Consonantia, there live the blind texts. Separated they live in Bookmarksgrove
                                        right
                                        at the coast of the Semantics, a large language ocean...
                                    </p>
                                    <div class="content-box-topic-view">
                                        <span>400 просмотров</span>
                                        <a href="#">
                                            <img src="images/icons/arrow-right.png" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 margin-top-20">
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-1-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-2-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-3-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                                <div class="row content-box-topic-row">
                                    <div class="col-md-4">
                                        <a href="">
                                            <img src="images/forum-topic-image-4-small.png" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="">
                                            <h2>Название топика - 1</h2>
                                        </a>
                                        <div class="content-box-topic-view">400 просмотров</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- close div /.content-box -->
                    <!--END Popular Forums-->

                </div><!-- close div /.col-md-6 -->
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