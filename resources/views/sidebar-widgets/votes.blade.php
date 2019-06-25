@php
    $random_question = $general_helper->getRandomQuestion();
@endphp
@if( Auth::user())
    <div class="widget-wrapper">
        <div class="widget-header">Голосование</div>
        @if(!empty($random_question))
            
            <div class="widget-title">{{$random_question->question}}</div>
            @if(isset($random_question->answers) && !empty($random_question->answers))
                <div id="view-results-response" class="view-results-response">
                    <form action="{{route('question.set_answer',['id' => $random_question->id])}}"
                        class="vote-form" method="GET" id="vote-question-form">
                        @csrf
                        @foreach($random_question->answers as $answer)
                            <div class="form-group display-flex align-items-center">
                                <input type="radio" id="answer_{{$answer->id}}" name="answer_id" value="{{$answer->id}}">
                                <label for="answer_{{$answer->id}}" >{{$answer->answer}}</label>
                            </div>
                        @endforeach
                        <div class="display-error text-center padding-top-bottom-5"></div>
                        <div class="justify-content-center display-flex">
                            <button class="btn-empty vote-button" type="submit">Проголосовать</button>
                        </div>
                    </form>
                </div>
                <div class="widget-footer">
                    <a href="#" id="view-answer-results"
                    data-url="{{route('question.view_answer',['id'=>$random_question->id])}}">
                        Посмотреть результаты</a>
                </div>
            @endif
        @else
            @php 
                $answers = $general_helper->getAnswers();
            @endphp
            <div class="widget-title">{{$answers->question}}</div>
                <div id="view-results-response" class="view-results-response">
                @php $total = 0; @endphp
                @foreach($answers->answers as $answer)
                    @php $total = $total + $answer->user_answers_count @endphp
                    <div class="vote-response">
                        <span>{!! $answer->answer !!}</span>
                        <span>{{$answer->user_answers_count}}</span>
                    </div>
                @endforeach
                <div class="sidebar-widget-subtitle">Total votes: {{$total}} </div>
            </div>
        @endif
    </div>
@endif



