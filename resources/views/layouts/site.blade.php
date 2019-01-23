
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
                        <div class="widget-navigation">
                            <ul id="menu" class="navigation">
                                <li class="active">
                                    <a href="index.html" class="menu-link">Главная</a>
                                </li>
                                <li>
                                    <a href=forum.html" class="has-arrow menu-link" aria-expanded="false">Форум</a>
                                    <ul class="submenu">
                                        <li>
                                            <a href="forum-section-articles.html" class="submenu-menu-link">Колонки</a>
                                        </li>
                                        <li>
                                            <a href="/" class="submenu-menu-link">Чемпионаты</a>
                                        </li>
                                        <li>
                                            <a href="/" class="submenu-menu-link">Интервью</a>
                                        </li>
                                        <li>
                                            <a href="/" class="submenu-menu-link">Статьи</a>
                                        </li>
                                        <li>
                                            <a href="/" class="submenu-menu-link">Стратегии</a>
                                        </li>
                                        <li>
                                            <a href="/" class="submenu-menu-link">Репортажи</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="has-arrow menu-link" aria-expanded="false">Реплеи</a>
                                    <ul class="submenu">
                                        <li>
                                            <a href="/" class="submenu-menu-link">Реплеи Юзеров</a>
                                        </li>
                                        <li>
                                            <a href="#" class="has-arrow submenu-menu-link" aria-expanded="false">Госу
                                                реплеи</a>
                                            <ul class="sub submenu">
                                                <li>
                                                    <a href="#" class="submenu-menu-link">игры 1 на 1</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="submenu-menu-link">Реплей паки</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="submenu-menu-link">Реплеи недели</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="submenu-menu-link">Командная игра</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="">
                                    <a href="#" class="menu-link">Новости</a>
                                </li>
                                <li>
                                    <a href="#" class="menu-link">Контакты</a>
                                </li>
                            </ul>
                        </div><!-- close div /.widget-navigation-->
                        <!--END Navigation-->
                        <!--Votes-->
                        <div class="widget-wrapper">
                            <div class="widget-header">Голосование</div>
                            <div class="widget-title">Вопрос голосовалки</div>
                            <form action="" class="vote-form">
                                <div class="form-group">
                                    <input type="radio" id="answer_1" name="answer" class="">
                                    <label for="answer_1">Ответ номер 1</label>

                                </div>
                                <div class="form-group">
                                    <input type="radio" id="answer_2" name="answer" class="">
                                    <label for="answer_2">Ответ номер 2</label>
                                </div>
                                <div class="form-group">
                                    <input type="radio" id="answer_3" name="answer" class="">
                                    <label for="answer_3">Ответ номер 3</label>
                                </div>
                                <div class="justify-content-center display-flex">
                                    <button class="btn-empty" type="submit">
                                        Проголосовать
                                    </button>
                                </div>
                            </form>
                            <div class="widget-footer">
                                <a href="#">Посмотреть результаты</a>
                            </div>
                        </div>
                        <!-- END Vote -->
                        <!-- Gosu Replay -->
                        <div class="widget-wrapper">
                            <div class="widget-header">Госу реплеи</div>
                            <div class="widget-replay row">
                                <div class="widget-map col-md-4">
                                    <img src="images/maps/map_1.png" alt="">
                                </div>
                                <div class="widget-replay-desc col-md-8">
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Название:</span>
                                        <span>Replay 38</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Страны:</span>
                                        <span>
                                                <span class="flag-icon flag-icon-kr"></span>
                                                VS
                                                <span class="flag-icon flag-icon-kr"></span>
                                            </span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Матчап:</span>
                                        <span>Z vs All</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Тип:</span>
                                        <span>1 на 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-replay row">
                                <div class="widget-map col-md-4">
                                    <img src="images/maps/map_2.png" alt="">
                                </div>
                                <div class="widget-replay-desc col-md-8">
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Название:</span>
                                        <span>Replay 38</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Страны:</span>
                                        <span>
                                                <span class="flag-icon flag-icon-kr"></span>
                                                VS
                                                <span class="flag-icon flag-icon-kr"></span>
                                            </span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Матчап:</span>
                                        <span>Z vs All</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Тип:</span>
                                        <span>1 на 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-replay row">
                                <div class="widget-map col-md-4">
                                    <img src="images/maps/map_3.png" alt="">
                                </div>
                                <div class="widget-replay-desc col-md-8">
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Название:</span>
                                        <span>Replay 38</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Страны:</span>
                                        <span>
                                                <span class="flag-icon flag-icon-kr"></span>
                                                VS
                                                <span class="flag-icon flag-icon-kr"></span>
                                            </span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Матчап:</span>
                                        <span>Z vs All</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Тип:</span>
                                        <span>1 на 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-replay row">
                                <div class="widget-map col-md-4">
                                    <img src="images/maps/map_4.png" alt="">
                                </div>
                                <div class="widget-replay-desc col-md-8">
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Название:</span>
                                        <span>Replay 38</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Страны:</span>
                                        <span>
                                                <span class="flag-icon flag-icon-kr"></span>
                                                VS
                                                <span class="flag-icon flag-icon-kr"></span>
                                            </span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Матчап:</span>
                                        <span>Z vs All</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Тип:</span>
                                        <span>1 на 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-replay row">
                                <div class="widget-map col-md-4">
                                    <img src="images/maps/map_5.png" alt="">
                                </div>
                                <div class="widget-replay-desc col-md-8">
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Название:</span>
                                        <span>Replay 38</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Страны:</span>
                                        <span>
                                                <span class="flag-icon flag-icon-kr"></span>
                                                VS
                                                <span class="flag-icon flag-icon-kr"></span>
                                            </span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Матчап:</span>
                                        <span>Z vs All</span>
                                    </div>
                                    <div class="widget-replay-desc-row">
                                        <span class="widget-replay-title">Тип:</span>
                                        <span>1 на 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="justify-content-center display-flex">
                                <a href="#" class="btn-empty margin-top-20" type="submit">
                                    Ещё
                                </a>
                            </div>
                        </div>
                        <!-- END Gosu Replay -->
                        <!-- Main Forum Topics -->
                        <div class="widget-wrapper">
                            <div class="widget-header">Основные темы форума</div>
                            <div class="widget-title">
                                <img src="images/icons/icon_columns.png" alt="">
                                Колонки:
                            </div>
                            <div class="widget-forum-topics-wrapper">
                                <div class="widget-forum-topic">
                                    <span>Как отдыхают настоящие мужчины</span>
                                    <span class="widget-forum-topic-comments">(33)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Народовольцы, В.И.Ленин и др. presents</span>
                                    <span class="widget-forum-topic-comments">(45)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Коробок спичек - понятие растяжимое...</span>
                                    <span class="widget-forum-topic-comments">(31)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Обращение к киберспорту</span>
                                    <span class="widget-forum-topic-comments">(29)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Демография</span>
                                    <span class="widget-forum-topic-comments">(21)</span>
                                </div>
                            </div>

                            <div class="widget-title">
                                <img src="images/icons/icon_interview.png" alt="">
                                Интервью:
                            </div>
                            <div class="widget-forum-topics-wrapper">
                                <div class="widget-forum-topic">
                                    <span>Как отдыхают настоящие мужчины</span>
                                    <span class="widget-forum-topic-comments">(33)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Народовольцы, В.И.Ленин и др. presents</span>
                                    <span class="widget-forum-topic-comments">(45)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Коробок спичек - понятие растяжимое...</span>
                                    <span class="widget-forum-topic-comments">(31)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Обращение к киберспорту</span>
                                    <span class="widget-forum-topic-comments">(29)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Демография</span>
                                    <span class="widget-forum-topic-comments">(21)</span>
                                </div>
                            </div>

                            <div class="widget-title">
                                <img src="images/icons/icon_posts.png" alt="">
                                Статьи:
                            </div>
                            <div class="widget-forum-topics-wrapper">
                                <div class="widget-forum-topic">
                                    <span>Как отдыхают настоящие мужчины</span>
                                    <span class="widget-forum-topic-comments">(33)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Народовольцы, В.И.Ленин и др. presents</span>
                                    <span class="widget-forum-topic-comments">(45)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Коробок спичек - понятие растяжимое...</span>
                                    <span class="widget-forum-topic-comments">(31)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Обращение к киберспорту</span>
                                    <span class="widget-forum-topic-comments">(29)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Демография</span>
                                    <span class="widget-forum-topic-comments">(21)</span>
                                </div>
                            </div>

                            <div class="widget-title">
                                <img src="images/icons/icon_strategy.png" alt="">
                                Стратегии:
                            </div>
                            <div class="widget-forum-topics-wrapper">
                                <div class="widget-forum-topic">
                                    <span>Как отдыхают настоящие мужчины</span>
                                    <span class="widget-forum-topic-comments">(33)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Народовольцы, В.И.Ленин и др. presents</span>
                                    <span class="widget-forum-topic-comments">(45)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Коробок спичек - понятие растяжимое...</span>
                                    <span class="widget-forum-topic-comments">(31)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Обращение к киберспорту</span>
                                    <span class="widget-forum-topic-comments">(29)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Демография</span>
                                    <span class="widget-forum-topic-comments">(21)</span>
                                </div>
                            </div>

                            <div class="widget-title">
                                <img src="images/icons/icon_reports.png" alt="">
                                Репортажи:
                            </div>
                            <div class="widget-forum-topics-wrapper">
                                <div class="widget-forum-topic">
                                    <span>Как отдыхают настоящие мужчины</span>
                                    <span class="widget-forum-topic-comments">(33)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Народовольцы, В.И.Ленин и др. presents</span>
                                    <span class="widget-forum-topic-comments">(45)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Коробок спичек - понятие растяжимое...</span>
                                    <span class="widget-forum-topic-comments">(31)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Обращение к киберспорту</span>
                                    <span class="widget-forum-topic-comments">(29)</span>
                                </div>
                                <div class="widget-forum-topic">
                                    <span>Демография</span>
                                    <span class="widget-forum-topic-comments">(21)</span>
                                </div>
                            </div>
                        </div>
                        <!-- END Main Forum Topics -->

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
<!--js into View-->
@yield('js')
<!--Custom scripts-->
<script src="{{route('home')}}/js/scripts.js"></script>
</body>
</html>