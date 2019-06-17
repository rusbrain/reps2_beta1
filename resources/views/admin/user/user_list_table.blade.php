@foreach($data->items() as $user)
    <tr>
        <td>{{$user->id}}</td>
        <td>
            <img class="direct-chat-img" src="{{route('home').($user->avatar?$user->avatar->link:'/dist/img/avatar.png')}}" alt="Аватар пользователя"><!-- /.direct-chat-img -->
        </td>
        <td><span class="user-name">{{$user->name}}</span></td>
        <td>{{$user->email}}</td>
        <td>{{$user->country->name??"Нет"}}</td>
        <td>{{$user->role->title??"Пользователь"}}</td>
        <td>{{$user->rating}}</td>
        <td>{{$user->topics_count}}</td>
        <td>{{$user->replays_count}}</td>
        <td>{{$user->user_galleries_count}}</td>
        <td>{{$user->comments_count}}</td>
        <td>{!! $user->email_verified_at?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
        <td>{!! $user->is_ban?'<i class="fa fa-ban text-red"></i>' : '<i class="fa fa-circle-o text-green"></i>'!!}</td>
        <td>{{$user->activity_at??"Нет"}}</td>
        <td>
            <div class="btn-group">
                @if(Auth::id() != $user->id)
                    <a type="button" class="btn btn-default text-green" title="Написать сообщение" href="{{route('admin.user.messages', ['id' => $user->id])}}"><i class="fa fa-send-o"></i></a>
                    <a type="button" class="btn btn-default text-purple" title="Написать письмо на E-mail"  href="{{route('admin.user.email', ['id' => $user->id])}}"><i class="fa fa-envelope-o"></i></a>
                @endif
                <a type="button" class="btn btn-default" title="Реплеи пользователя" href="{{route('admin.user.replay', ['id' => $user->id])}}"><i class="fa fa-film"></i></a>
                <a type="button" class="btn btn-default text-aqua"  title="Темы пользователя на форуме" href="{{route('admin.user.topic', ['id' => $user->id])}}"><i class="fa fa-list"></i></a>
                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть профиль пользователя" href="{{route('admin.user.profile', ['id' => $user->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  href="{{route('admin.user.profile.edit', ['id' => $user->id])}}"><i class="fa fa-edit"></i></a>
                @if($user->is_ban)
                    <a type="button" class="btn btn-default text-olive" title="Снять блокировку пользователя" href="{{route('admin.user.not_ban', ['id' => $user->id])}}"><i class="fa fa-thumbs-o-up"></i></a>
                @else
                    <a type="button" class="btn btn-default text-yellow"  title="Заблокировать пользователя" href="{{route('admin.user.ban', ['id' => $user->id])}}"><i class="fa fa-thumbs-o-down"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить пользователя" href="{{route('admin.user.remove', ['id' => $user->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach