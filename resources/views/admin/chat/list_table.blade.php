@foreach($data->items() as $message)
    <tr>
        <td>{{$message->id}}</td>
        <td><a href="{{route('admin.user.profile', ['id' => $message->user->id])}}">{{$message->user->name}}</a></td>
        <td><a href="{{route('admin.chat.view', ['id' => $message->id])}}">{!! $message->message !!}</a></td>
        <td>{{$message->created_at}}</td>       
        <td>
            <div class="btn-group">              
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.chat.remove', ['id' => $message->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach
