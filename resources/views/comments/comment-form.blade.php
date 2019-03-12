<form action="{{$route}}" class="add-comment-form" method="POST">
    @csrf
    <div class="form-group">
        <label for="comment-title">Заголовок</label>
        <input type="text" name="title" id="comment-title" class="form-control" value="">
    </div>
    <div class="form-group">
        <label for="comment-content">Комментарий</label>
        <textarea name="content" id="comment-content"
                  class="form-control comment-content" rows="8">{!! old('content')!!}</textarea>
    </div>
    <input type="hidden" name="relation" value="{{$relation}}">
    <input type="hidden" name="{{$comment_type}}" value="{{$object_id}}">

    <button type="submit" class="btn-blue comment-send">Отправить</button>
</form>