@php $total = 0; @endphp
@foreach($answers->answers as $answer)
    @php $total = $total + $answer->user_answers_count @endphp
    <div class="vote-response">
        <span>{!! $answer->answer !!}</span>
        <span>{{$answer->user_answers_count}}</span>
    </div>
@endforeach
<div class="sidebar-widget-subtitle">Total votes: {{$total}} </div>