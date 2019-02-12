@foreach($data->items() as $topic)
    <tr>
        <td>{{$topic->id}}</td>
        <td><a href="{{route('forum.topic.index', ['id' => $topic->id])}}">{{$topic->title}}</a></td>
        <td><a href="{{route('admin.forum_topic', ['section_id' => $topic->section->id])}}">{{$topic->section->title}}</a></td>
        <td>
            <a href="{{route('admin.user.profile', ['id' => $topic->user->id])}}">{{$topic->user->name}}</a>
        </td>

        <td>
            <i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>{{$topic->positive_count}} /
            <i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>{{$topic->negative_count}}
            - ({{$topic->rating}})
        </td>
        <td>{{$topic->comments_count}}</td>
        <td>{{$topic->reviews}}</td>
        <td>{!! $topic->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
        <td>{!! $topic->news?'<i class="fa fa-newspaper-o text-blue"></i>':'<i class="fa  fa-newspaper-o text-gray"></i>' !!}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-aqua"  title="Просмотреть запись" href="{{route('admin.forum.topic.get', ['id' => $topic->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править запись"  href="{{route('admin.forum.topic.edit', ['id' => $topic->id])}}"><i class="fa fa-edit"></i></a>
                @if(!$topic->approved)
                    <a type="button" class="btn btn-default text-green" title="Одобрить запись" href="{{route('admin.forum.topic.approve', ['id' => $topic->id])}}"><i class="fa fa-check"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Заблокировать запись" href="{{route('admin.forum.topic.unapprove', ['id' => $topic->id])}}"><i class="fa fa-ban"></i></a>
                @endif
                @if(!$topic->news)
                    <a type="button" class="btn btn-default text-blue" title="Сделать новостью" href="{{route('admin.forum.topic.news', ['id' => $topic->id])}}"><i class="fa fa-newspaper-o"></i></a>
                @else
                    <a type="button" class="btn btn-default text-grey"  title="Убрать из новостей" href="{{route('admin.forum.topic.not_news', ['id' => $topic->id])}}"><i class="fa fa-newspaper-o"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить запись" href="{{route('admin.forum.topic.remove', ['id' => $topic->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach