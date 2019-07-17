@foreach($data->items() as $log)
    <tr>
        <td>{{ __('messages.user_activity_log.type.'.$log->type) }}</td>
        <td><a href="{{ route('admin.user.activity-log', ['user' => $log->user_id]) }}">{{ $log->user->name }}</a></td>
        <td>{{ $log->time }}</td>
        <td>{!! $log->getDescription() !!}</td>
        <td>{!! $log->getDetails() !!}</td>
    </tr>
@endforeach
