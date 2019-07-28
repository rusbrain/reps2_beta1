@foreach($data->items() as $picture)
    <tr>
        <td>{{$picture->id}}</td>
        <td>
            <img class="img-preview" src="{{route('home').($picture->file->link??'/dist/img/default-50x50.gif')}}" alt="Изображение">
        </td>
        <td><a href="{{route('admin.user.profile', ['id' => $picture->user->id])}}">{{$picture->user->name}}</a></td>
        <td>{{$picture->category}}</td>
        <td>{{$picture->charactor}}</td>
        <td>{{$picture->comment}}</td>        
        <td>{{$picture->created_at}}</td>

        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-orange"  title="Править"  href="{{route('admin.chat.pictures.edit', ['role' => $picture->id])}}"><i class="fa fa-edit"></i></a>
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.chat.pictures.remove', ['id' => $picture->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach