@foreach($data->items() as $message)
    <tr>
        <td>{{$message->id}}</td>
        <td><a href="{{route('admin.user.profile', ['id' => $message->user->id])}}">{{$message->user->name}}</a></td>
        <td><a href="{{route('admin.chat.view', ['id' => $message->id])}}">{!! $message->message !!}</a></td>
        <td>{{$message->created_at}}</td>       
        {{-- <td>{!! $message->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td> --}}
        <td>
            <div class="btn-group">
                {{-- <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть" href="{{route('admin.chat.view', ['role' => $message->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править"  href="{{route('admin.chat.edit', ['role' => $message->id])}}"><i class="fa fa-edit"></i></a> --}}
                {{-- @if(!$message->approved)
                    <a type="button" class="btn btn-default text-green" title="Подтвердить" href="{{route('admin.chat.approve', ['id' => $message->id])}}"><i class="fa fa-check"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Снять подтверждение" href="{{route('admin.chat.not_approve', ['id' => $message->id])}}"><i class="fa fa-clock-o"></i></a>
                @endif --}}
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.chat.remove', ['id' => $message->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach