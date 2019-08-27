@foreach($data->items() as $log)
    <tr>
        <td>{{ __('messages.user_activity_log.type.'.$log->type) }}</td>
        <td><a href="{{ route('admin.user.profile', ['id' => $log->user_id]) }}" target="_blank">{{ $log->user->name }}</a></td>
        <td>{{ $log->time }}</td>
        <td><a href="{{ route('admin.user.activity-log', ['ip' => $log->ip]) }}">{{ $log->ip }}</a></td>
        <td>{!! $log->getDescription() !!}</td>
        <td>{!! $log->getDetails() !!}</td>
    </tr>
@endforeach
