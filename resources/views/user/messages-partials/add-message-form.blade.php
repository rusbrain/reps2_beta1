@section('css')
    <!--SCEditor -  WYSIWYG BBCode editor -->
    <link rel="stylesheet" href="{{route('home')}}/js/sceditor/minified/themes/default.min.css"/>
@endsection
<form action="" method="POST" class="user-message-form">
    <div class="form-group">
        <label for="message">Написать сообщение:</label>
        <textarea name="message" id="message" class="form-control send-message-text"
                  rows="10" maxlength="1000"></textarea>
        <input type="hidden" name="load-more" value="{{$messages->url($page??2)}}">
    </div>
    <div class="form-group">
        <button type="submit" class="btn-blue btn-form">Отправить</button>
    </div>
</form>