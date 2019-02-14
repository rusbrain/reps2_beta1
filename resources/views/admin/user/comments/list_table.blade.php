@inject('general_helper', 'App\Services\GeneralViewHelper')

@foreach($data->items() as $comment)
    <tr>
        <td>{{$comment->id}}</td>
        <td>
            @if($comment->relation == \App\UserReputation::RELATION_FORUM_TOPIC)
                Тема форума <a href="{{route('forum.topic.index', ['id' => $comment->topic->id])}}">{!! $comment->topic->title !!}</a>
            @elseif($comment->relation == \App\UserReputation::RELATION_USER_GALLERY)
                Пост в галлерее <a href="{{route('gallery.view', ['id' => $comment->gallery->id])}}">{{$comment->gallery->id}}</a>
            @elseif($comment->relation == \App\UserReputation::RELATION_REPLAY)
                Replay <a href="{{route('replay.get', ['id' => $comment->replay->id])}}">{!! $comment->replay->title !!}</a>
            @endif
        </td>
        <td>{!! $comment->title !!}</td>
        <td>{!! $comment->content !!}</td>
        <td>{{$comment->created_at}}</td>
        <td style="text-align: center">
            <div class="btn-group">
                <a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.user.comments.remove', ['id' => $comment->user_id,'comments_id' => $comment->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach

