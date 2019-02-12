@foreach($data->items() as $country)
<tr>
    <td>{{$country->id}}</td>
    <td>{{$country->name}}</td>
    <td>{{$country->code}}</td>
    <td>{{$country->replay1_count + $country->replay2_count +$country->users_count}}</td>
    <td>
        <div class="btn-group">
            <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_{{$country->id}}" href="{{route('admin.country.edit', ['id' => $country->id])}}"><i class="fa fa-edit"></i></a>
            <a type="button" class="btn btn-default text-red"  title="Удалить пользователя" href="{{route('admin.country.remove', ['id' => $country->id])}}"><i class="fa fa-trash"></i></a>
        </div>
    </td>
</tr>
@endforeach