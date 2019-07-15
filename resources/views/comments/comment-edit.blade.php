{{--@extends('layouts.site')--}}
@extends('home.index')

@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

@section('content')
    <div class="content-box">
        <div class="col-md-12 section-title">
            <div>Редактировать комментарий:</div>
        </div>
        <div class="col-md-12 comment-form-wrapper">
        @if(Auth::user())
            <!--COMMENT FORM-->
                <form action="{{route($route, ['id' => $comment->id])}}" class="add-comment-form" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="comment-title">Заголовок</label>
                        <input type="text" name="title" id="comment-title" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="comment-content">Комментарий</label>
                        <textarea name="content" id="comment-content"
                                  class="form-control comment-content" rows="8">{!! old('content', $comment->content)!!}</textarea>
                    </div>
                    <input type="hidden" name="relation" value="{{$relation}}">
                    <input type="hidden" name="{{$comment_type}}" value="{{$object_id}}">

                    <button type="submit" class="btn-blue comment-send">Отправить</button>
                </form>
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

@section('js')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.min.js"></script>

    <script src="{{route('home')}}/js/sceditor/minified/jquery.sceditor.xhtml.min.js"></script>
    <script src="{{route('home')}}/js/sceditor/languages/ru.js"></script>

    <script>
        /**
         * Comments box is the same for all pages
         *SCEditor -  WYSIWYG BBCode editor
         * https://www.sceditor.com/
         * */
        $(function () {
            /**custom commands for HTML text editor*/
            addCountries();
            addRaces();
            addSpoiler();

            if ($('body').find('#comment-content').length > 0) {
                var textarea = document.getElementById('comment-content');

                sceditor.create(textarea, {
                    format: 'xhtml',
                    style: '{{route('home')}}' + '/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route('home')}}' + '/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                        'left,center,right,justify|' +
                        'font,size,color,removeformat|' +
                        'source,quote,code|' +
                        'image,link,unlink|' +
                        'emoticon|' +
                        'date,time|' +
                        'countries|'+
                        'races|spoiler',
                    emoticons: {
                        // Emoticons to be included in the dropdown
                        dropdown: getAllSmiles(),
                        // Emoticons to be included in the more section
                        more: getMoreSmiles()
                    }
                });
            }
        });
    </script>
@endsection
