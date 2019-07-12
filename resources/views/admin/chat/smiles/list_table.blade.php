@foreach($data->items() as $smile)
    <tr>
        <td>{{$smile->id}}</td>
        <td>
            <img class="img-preview" src="{{route('home').($smile->file->link??'/dist/img/default-50x50.gif')}}" alt="Изображение">
        </td>
        <td><a href="{{route('admin.user.profile', ['id' => $smile->user->id])}}">{{$smile->user->name}}</a></td>
        <td>{{$smile->comment}}</td>
        <td>{{$smile->charactor}}</td>

        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-orange"  data-toggle="modal" data-target="#modal-default_{{$smile->id}}" title="Править"  href="{{route('admin.chat.smiles.edit', ['role' => $smile->id])}}"><i class="fa fa-edit"></i></a>
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.chat.smiles.remove', ['id' => $smile->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach