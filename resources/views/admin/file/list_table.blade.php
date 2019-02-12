@foreach($data->items() as $file)
    @php
    $count = $file->banner_count + $file->country_count + $file->forum_topic_count + $file->replay_count + $file->avatar_count + $file->user_gallery_count;
    @endphp
    <tr>
        <td>{{$file->id}}</td>
        <td>
            <a class="img-preview" href="{{route('admin.file.download', ['id' => $file->id])}}">Скачать/Просмотреть</a>
        </td>
        <td>{{$file->title}}</td>
        <td>{{$file->type??"Не определен"}}</td>
        <td>{{$file->size?round($file->size/1024):"Не определен"}}</td>
        <td>{!! $count > 0?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-minus text-red"></i>' !!}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-orange"  title="Править"  data-toggle="modal" data-target="#modal-default_{{$file->id}}" href="{{route('admin.file.edit', ['id' => $file->id])}}"><i class="fa fa-edit"></i></a>
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.file.remove', ['id' => $file->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach