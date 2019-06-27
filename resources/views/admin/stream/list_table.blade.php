@foreach($data->items() as $stream)
    <tr>
        <td>{{$stream->id}}</td>
        <td><a href="{{route('admin.user.profile', ['id' => $stream->user->id])}}">{{$stream->user->name}}</a></td>
        <td><a href="{{route('admin.stream.view', ['id' => $stream->id])}}">{{$stream->title}}</a></td>
       
        <td>{!! $stream->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть" href="{{route('admin.stream.view', ['role' => $stream->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править"  href="{{route('admin.stream.edit', ['role' => $stream->id])}}"><i class="fa fa-edit"></i></a>
                @if(!$stream->approved)
                    <a type="button" class="btn btn-default text-green" title="Подтвердить" href="{{route('admin.stream.approve', ['id' => $stream->id])}}"><i class="fa fa-check"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Снять подтверждение" href="{{route('admin.stream.not_approve', ['id' => $stream->id])}}"><i class="fa fa-clock-o"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.stream.remove', ['id' => $stream->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach