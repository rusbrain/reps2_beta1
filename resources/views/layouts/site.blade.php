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
    <link rel="stylesheet" href="{{route('home')}}/css/message.css">

    <title>Главная | Reps.ru</title>
</head>
<body>
@inject('general_helper', 'App\Services\GeneralViewHelper')

@php 
    $streamSettings = $general_helper->getStreamSettings();
    $path = $general_helper->getActivePath();
@endphp
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
            <!--Stream Section-->  
            @if(!empty($streamSettings) && $path == '/')  
                @if($streamSettings->headline)        
                    <div class="row">
                        <div class="col-md-12">
                            <div class="stream-headline-wrapper">
                                @yield('stream-header')
                            </div>
                        </div>
                    </div>
                @endif
                @if($streamSettings->main_section)
                    <div class="row stream-section">               
                                            
                        <div class="col-md-12 stream-area chat_open theatre-off">
                            <div class="stream-message-wrapper">
                                @yield('stream-message')
                            </div>
                            <div class="stream-wrapper" id="video-frame-container">
                                <div class="load-wrapp">
                                    <img src="/images/loader.gif" alt="">
                                </div>
                            </div>
                            <div class="streamlist">
                                <div class="stream-list-wrapper">
                                    @yield('stream-list')
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <!--END Stream Section-->
           
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
                <div class="col-md-6 main-content">
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

<div class="button-up">
    <img src="{{route('home')}}/images/icons/arrow_up.png" alt="">
</div>

<!-- ========ALL MODAL WINDOWS ============== -->
<div class="modal fade" id="vote-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Оставте комментарий</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::user() )
                    <form id="rating-vote-form" action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Голос:
                                <div class="positive">
                                    <img src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                                </div>
                                <div class="negative">
                                    <img src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                                </div>
                            </label>
                            <input type="hidden" name="rating" id="rating" value="">
                        </div>
                        <div class="form-group">
                            <label for="comment">Комментарий</label>
                            <input type="text" class="form-control" name="comment" id="comment" value="">
                        </div>
                        <button class="btn-blue btn-form" type="submit">Проголосовать</button>
                    </form>
                @else
                    <div class="unregistered-info-wrapper">
                        <div class="notice">
                            Данная опция доступна только авторизированным пользователям
                        </div>
                        <div class="btn-wrapper">
                            <a href="/" class="btn-blue btn-form">Авторизироваться</a>
                            <a href="{{route('registration_form')}}"
                               class="btn-blue btn-form">Зарегистрироваться</a>
                        </div>
                    </div>
                @endif
                <div class="unregistered-info-wrapper info-block display-none">
                    <div class="notice"></div>
                    <img class="positive-vote-img" src="{{route('home')}}/images/icons/thumbs-up.png" alt="">
                    <img class="negative-vote-img" src="{{route('home')}}/images/icons/thumbs-down.png" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========== END ALL MODAL WINDOWS ============ -->

{{-- Sceditor UPload overlay --}}
<div class="upload-overlay">    
    <div class="showImages">
        <span class="close_overlay"></span>
        <div class="all_images"></div>
       
        <button class="open_img">Open</span>
          
    </div>
</div>

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
<script src="{{route('home')}}/js/socket.io.js"></script>
<script src="{{route('home')}}/js/message.js"></script>


</body>
</html>