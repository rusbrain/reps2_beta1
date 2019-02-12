@foreach($data->items() as $section)
    <tr>
        <td>{{$section->id}}</td>
        <td>{{$section->title}}</td>
        <td>{{$section->name}}</td>
        <td>{{$section->position}}</td>
        <td>{{$section->description}}</td>
        <td>{{$section->topics_count}}</td>
        <td>{!! $section->is_active?'<i class="fa fa-check text-green"></i>':'<i class="fa fa-ban text-red"></i>' !!}</td>
        <td>{!! $section->is_general?'<i class="fa fa-plus text-blue"></i>':'<i class="fa fa-minus text-gray"></i>' !!}</td>
        <td>{!! $section->user_can_add_topics?'<i class="fa fa-plus text-green"></i>':'<i class="fa fa-minus text-red"></i>' !!}</td>
        <td>
            <div class="btn-group">
                <a type="button" class="btn btn-default text-aqua"  title="Просмотреть раздел" href="{{route('admin.forum_topic', ['section_id' => $section->id])}}"><i class="fa fa-eye"></i></a>
                <a type="button" class="btn btn-default text-orange"  title="Править опздел"  href="{{route('admin.forum.section.edit', ['id' => $section->id])}}"><i class="fa fa-edit"></i></a>
                @if(!$section->is_active)
                    <a type="button" class="btn btn-default text-green" title="Сделать раздел активным" href="{{route('admin.forum.section.active', ['id' => $section->id])}}"><i class="fa fa-check"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Сделать раздел не активным" href="{{route('admin.forum.section.not_active', ['id' => $section->id])}}"><i class="fa fa-ban"></i></a>
                @endif
                @if(!$section->is_general)
                    <a type="button" class="btn btn-default text-blue" title="Сделать раздел главным" href="{{route('admin.forum.section.general', ['id' => $section->id])}}"><i class="fa fa-plus"></i></a>
                @else
                    <a type="button" class="btn btn-default text-gray"  title="Сделать раздел обычным" href="{{route('admin.forum.section.not_general', ['id' => $section->id])}}"><i class="fa fa-minus"></i></a>
                @endif
                @if(!$section->user_can_add_topics)
                    <a type="button" class="btn btn-default text-green" title="Пользователь сможет добалять темы в этот раздел" href="{{route('admin.forum.section.user_can', ['id' => $section->id])}}"><i class="fa fa-plus"></i></a>
                @else
                    <a type="button" class="btn btn-default text-red"  title="Пользователь не сможет добалять темы в этот раздел" href="{{route('admin.forum.section.user_not_can', ['id' => $section->id])}}"><i class="fa fa-minus"></i></a>
                @endif
                <a type="button" class="btn btn-default text-red"  title="Удалить раздел со всеми темами" href="{{route('admin.forum.section.remove', ['id' => $section->id])}}"><i class="fa fa-trash"></i></a>
            </div>
        </td>
    </tr>
@endforeach