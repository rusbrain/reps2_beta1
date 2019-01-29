@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection

<form action="{{$route}}" class="add-comment-form" method="POST">
    @csrf
    <div class="form-group">
        <label for="comment-title">Заголовок</label>
        <input type="text" name="" id="comment-title" class="form-control" value="">

    </div>
    <div class="form-group">
        <label for="comment-content">Комментарий</label>
        <textarea name="content" id="comment-content"
                  class="form-control comment-content" rows="12">{!! old('content')!!}</textarea>
    </div>

    <input type="hidden" name="relation" value="{{$relation}}">
    <input type="hidden" name="{{$comment_type}}" value="{{$object_id}}">

    <button type="submit" class="btn-blue comment-send">Отправить</button>
</form>
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
            if ($('#comment-content').length > 0) {
                var textarea = document.getElementById('comment-content');

                sceditor.create(textarea, {
                    format: 'xhtml',
                    style: '{{route('home')}}'+'/js/sceditor/minified/themes/content/default.min.css',
                    emoticonsRoot: '{{route('home')}}'+'/js/sceditor/',
                    locale: 'ru',
                    toolbar: 'bold,italic,underline|' +
                    'left,center,right,justify|' +
                    'font,size,color,removeformat|' +
                    'source,quote,code|' +
                    'image,link,unlink|' +
                    'emoticon|' +
                    'date,time'
                });
            }
        });
    </script>
@endsection