@foreach($data->items() as $map)
    <tr>
        <td>{{$map->id}}</td>
        <td>
            <img class="img-preview" src="{{route('home').'/'.$map->url}}" alt="Изображение">
        </td>
        <td>{{$map->name}}</td>
        <td>{{$map->replay_count}}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-orange"  title="Править"  data-toggle="modal" data-target="#modal-default_{{$map->id}}" href="{{route('admin.replay.map.edit', ['id' => $map->id])}}"><i class="fa fa-edit"></i></a>
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.replay.map.remove', ['id' => $map->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach