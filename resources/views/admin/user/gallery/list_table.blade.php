@foreach($data->items() as $gallery)
    <tr>
        <td>{{$gallery->id}}</td>
        <td>
            <img class="img-preview" src="{{route('home').($gallery->file->link??'/dist/img/default-50x50.gif')}}" alt="Изображение">
        </td>
        <td><a href="{{route('admin.user.profile', ['id' => $gallery->user->id])}}">{{$gallery->user->name}}</a></td>
        <td>{{$gallery->comment}}</td>
        <td>{!! $gallery->for_adults?'<i class="fa fa-check text-red"></i>':'<i class="fa fa-minus text-gray"></i>' !!}</td>
        <td> <i class="fa fa-thumbs-o-up margin-r-5 text-green"></i>{{$gallery->positive_count}} /
            <i class="fa fa-thumbs-o-down margin-r-5 text-red"></i>{{$gallery->negative_count}}
            - ({{$gallery->rating}})</td>
        <td>{{$gallery->comments_count}}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть" href="{{route('admin.users.gallery.view', ['id' => $gallery->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$gallery->id}}" href="{{route('admin.user.gallery.edit', ['id' => $gallery->id])}}"><i class="fa fa-edit"></i></a>
                @if($gallery->for_adults)
                    <a type="button" class="btn btn-default text-gray"  title="Снять отметку 18+" href="{{route('admin.users.gallery.not_for_adults', ['id' => $gallery->id])}}"><i class="fa fa-minus text-gray"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red" title="Пометить как 18+" href="{{route('admin.users.gallery.for_adults', ['id' => $gallery->id])}}"><i class="fa fa-check"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.users.gallery.remove', ['id' => $gallery->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach