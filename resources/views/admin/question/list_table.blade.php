@foreach($data->items() as $question)
<tr>
    <td>{{$question->id}}</td>
    <td>{{$question->question}}</td>
    <td>{{$question->answers_count}}</td>
    <td>{{$question->user_answers_count}}</td>
    <td>{!! $question->is_active?'<i class="fa fa-check text-aqua"></i>':'<i class="fa fa-clock-o text-red"></i>' !!}</td>
    <td>{!! $question->for_login?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-minus"></i>' !!}</td>
    <td>{!! $question->is_favorite?'<i class="fa fa-plus text-green"></i>':'<i class="fa fa-minus text-gray"></i>' !!}</td>
    <td>
        <div class="btn-group">
            <a type="button" class="btn btn-default text-fuchsia"  title="Просмотреть профиль пользователя" data-toggle="modal" data-target="#modal-default_view_{{$question->id}}" href="{{route('admin.question.view', ['id' => $question->id])}}"><i class="fa fa-eye"></i></a>
            <a type="button" class="btn btn-default text-orange"  title="Править профиль пользователя"  data-toggle="modal" data-target="#modal-default_edit_{{$question->id}}" href="{{route('admin.question.edit', ['id' => $question->id])}}"><i class="fa fa-edit"></i></a>
            @if(!$question->is_active)
                <a type="button" class="btn btn-default text-aqua" title="Сделать активным" href="{{route('admin.question.active', ['id' => $question->id])}}"><i class="fa fa-check"></i></a>
            @else
                <a type="button" class="btn btn-default text-red"  title="Сделать не активным" href="{{route('admin.question.not_active', ['id' => $question->id])}}"><i class="fa fa-clock-o"></i></a>
            @endif
            @if(!$question->for_login)
                <a type="button" class="btn btn-default text-green" title="Сделать доступным только для авторизорованных" href="{{route('admin.question.for_login', ['id' => $question->id])}}"><i class="fa fa-check"></i></a>
            @else
                <a type="button" class="btn btn-default"  title="Сделать доступным для всех" href="{{route('admin.question.not_for_login', ['id' => $question->id])}}"><i class="fa fa-minus"></i></a>
            @endif
            @if(!$question->is_favorite)
                <a type="button" class="btn btn-default text-green" title="Сделать приоритетным" href="{{route('admin.question.favorite', ['id' => $question->id])}}"><i class="fa fa-plus"></i></a>
            @else
                <a type="button" class="btn btn-default text-gray"  title="Сделать не приоритетным" href="{{route('admin.question.not_favorite', ['id' => $question->id])}}"><i class="fa fa-minus"></i></a>
            @endif
            <a type="button" class="btn btn-default text-red"  title="Удалить пользователя" href="{{route('admin.question.remove', ['id' => $question->id])}}"><i class="fa fa-trash"></i></a>
        </div>
    </td>
</tr>
@endforeach