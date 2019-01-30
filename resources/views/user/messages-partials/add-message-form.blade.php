@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection
<form action=""  method="POST" class="user-message-form">
    <div class="form-group">
        <label for="message">Написать сообщение:</label>
        <textarea name="message" id="message" class="form-control send-message-text"
                  rows="10"></textarea>
        <input type="hidden" name="load-more" value="{{$messages->url($page??2)}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn-blue btn-form">Отправить</button>
    </div>
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
            if ($('.user-message-form').length > 0) {
                var textarea = document.getElementById('message');

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

                $('.user-message-form').on('submit', function (e) {
                    e.preventDefault();

                    var message = $('.send-message-text').val();
                    var url = $('input[name=load-more]').val();

                    sceditor.instance(textarea).val('');

                    $.post(
                        '{{route('user.message.send', ['id'=>$dialog_id])}}',
                        {
                            message: message,
                            _token: '{{csrf_token()}}'
                        },
                        function (data) {
                            $('.messages-box').html(data);
                            $('.messages-box').scrollTop($(".scroll-to").offset().top);
                        }
                    );
                });

                $('.messages-box').scrollTop($(".scroll-to").offset().top);

                $('.messages-box').on('click', '.load-more', function () {
                    var url = $('.load-more').attr('date-href');
                    console.log(url);
                    $.post(
                        url,
                        {
                            _token: '{{csrf_token()}}'
                        },
                        function (data) {
                            $('.load-more-box').remove();
                            $('.messages-box').prepend(data);
                        }
                    );
                })
            }
        });
    </script>
@endsection