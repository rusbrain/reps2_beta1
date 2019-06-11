{{--@extends('layouts.site')--}}
@extends('forum.topic')

@section('content')
    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Редактировать комментарий:</div>
        </div>
        <div class="col-md-12 comment-form-wrapper">
        @if(Auth::user())
            <!--COMMENT FORM-->
            @include('comments.comment-form')
            <!--END COMMENT FORM-->
        @else
            <!--if you are not logged-->
                <div class="no-logged-user">
                    <div>
                        <img src="{{route('home')}}/images/icons/icon_flag_ru.png" alt="">
                        <span>Вы не зарегистрированы на сайте, поэтому данная функция отсутствует.</span>
                    </div>
                    <div>
                        <img src="{{route('home')}}/images/icons/icon_flag_en.png" alt="">
                        <span>You are not registered on the site and this function is disabled.</span>
                    </div>
                </div>
            @endif
        </div><!-- close div /.comment-form-wrapper-->
    </div><!-- close div /.content-box-->
@endsection
