@foreach($data->items() as $reputation)
    <tr>
        <td>{{$reputation->id}}</td>
        <td>
            <a href="{{route('admin.user.profile', ['id' => $reputation->sender->id])}}">{{$reputation->sender->name}}</a>
        </td>
        <td>
            @if($reputation->relation == \App\UserReputation::RELATION_FORUM_TOPIC)
                Тема форума <a href="{{route('forum.topic.index', ['id' => $reputation->topic->id])}}">{!! $reputation->topic->title !!}</a>
            @elseif($reputation->relation == \App\UserReputation::RELATION_USER_GALLERY)
                Пост в галлерее <a href="{{route('gallery.view', ['id' => $reputation->gallery->id])}}">{{$reputation->gallery->id}}</a>
            @elseif($reputation->relation == \App\UserReputation::RELATION_REPLAY)
                Replay <a href="{{route('replay.get', ['id' => $reputation->replay->id])}}">{!! $reputation->replay->title !!}</a>
            @elseif($reputation->relation == \App\UserReputation::RELATION_COMMENT)
                Комментарий {{--<a href="{{route('forum.topic.index', ['id' => $reputation->id])}}">{{$reputation->title}}</a>--}}
            @endif
        </td>
        <td>@if($reputation->rating == 1)
                <i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>
            @elseif($reputation->rating == -1)
                <i class="fa fa-thumbs-o-down margin-r-5 text-red">
            @endif
        </td>
        <td>{!! $reputation->comment!!}</td>
        <td>{{$reputation->created_at}}</td>
        <td style="text-align: center">
            <div class="btn-group">
                <a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.user.reputation.remove', ['id' => $reputation->recipient_id,'reputation_id' => $reputation->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach
{{--{{dd($data)}}--}}
