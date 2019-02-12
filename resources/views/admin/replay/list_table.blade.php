@foreach($data->items() as $replay)
    <tr>
        <td>{{$replay->id}}</td>
        <td><a href="{{route('admin.user.profile', ['id' => $replay->user->id])}}">{{$replay->user->name}}</a></td>
        <td><a href="{{route('replay.get', ['id' => $replay->id])}}">{{$replay->title}}</a></td>
        <td>{{($replay->map != null)? $replay->map->name:"Нет" }}</td>
        <td>{{($replay->first_country->name??"Нет")}} vs {{($replay->second_country->name??"Нет")}}</td>
        <td>{{$replay->first_race}} vs {{$replay->second_race}}</td>
        <td>{{$replay->type->title}}({{$replay->type->name}})</td>
        <td>{{($replay->user_replay == 1)?"Пользоватлеьский":"Gosu"}}</td>
        <td>{{$replay->comments_count}}</td>
        <td>
            <a type="button" title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$replay->id}}"
               href="{{route('admin.replay.user_rating', ['id' => $replay->id])}}">
                {{$replay->user_rating}} ({{$replay->user_rating_count}})
            </a>
        </td>
        <td><i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>{{$replay->positive_count}} /
            <i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>{{$replay->negative_count}}
            - ({{$replay->rating}})</td>
        <td>{!! $replay->approved?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть" href="{{route('admin.replay.view', ['role' => $replay->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править"  href="{{route('admin.replay.edit', ['role' => $replay->id])}}"><i class="fa fa-edit"></i></a>
                @if(!$replay->approved)
                    <a type="button" class="btn btn-default text-green" title="Подтвердить" href="{{route('admin.replay.approve', ['id' => $replay->id])}}"><i class="fa fa-check"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Снять подтверждение" href="{{route('admin.replay.not_approve', ['id' => $replay->id])}}"><i class="fa fa-clock-o"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.replay.remove', ['id' => $replay->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach