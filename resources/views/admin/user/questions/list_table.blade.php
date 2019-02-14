@inject('general_helper', 'App\Services\GeneralViewHelper')

@foreach($data->items() as $answer)
    <tr>
        <td>{{$answer->id}}</td>
        <td>{{ $answer->question->question }}</td>
        <td>{{ $answer->answer->answer }}</td>
        <td>{{$answer->created_at}}</td>
    </tr>
@endforeach

