@foreach($data->items() as $category)
    <tr>
        <td>{{$category->id}}</td>       
        <td>{{$category->name}}</td>
        <td>{{$category->comment}}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-orange"  data-toggle="modal" data-target="#modal-default_{{$category->id}}" title="Править"  href="{{route('admin.chat.pictures.category.edit', ['role' => $category->id])}}"><i class="fa fa-edit"></i></a>
                <a type="button" class="btn btn-default text-red"  title="Удалить" href="{{route('admin.chat.pictures.category.remove', ['id' => $category->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach