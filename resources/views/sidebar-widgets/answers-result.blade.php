    @php $total = 0; @endphp
    @foreach($answers->answers as $answer)
        @php $total = $total + $answer->user_answers_count @endphp
        <p class="vote-response"><span>{!! $answer->answer !!}</span> <span>{{$answer->user_answers_count}}</span></p>
    @endforeach
    <div class="sidebar-widget-subtitle">Total votes: {{$total}} </div>