@php
    $random_questions = $general_helper->getRandomQuestion();
    $user_questions = $general_helper->getUserQuestions();
@endphp
@if( Auth::user() && (!empty($random_questions || !empty($user_questions) ) )  ) 
    <div class="widget-wrapper">
        <div class="widget-header">Голосование</div>  
        @if(!empty($random_questions))
            @foreach($random_questions as $key => $random_question)
                <div class="widget-title">{{$random_question->question}}</div>
                @if(isset($random_question->answers) && !empty($random_question->answers))
                    <div id="view-results-response-{{$key}}" class="view-results-response">
                        <form action="{{route('question.set_answer',['id' => $random_question->id])}}"
                            class="vote-form" method="GET" id="vote-question-form-{{$key}}" data-num ="{{$key}}">
                            @csrf
                            @foreach($random_question->answers as $answer)
                                <div class="form-group display-flex align-items-center">
                                    <input type="radio" id="answer_{{$answer->id}}" name="answer_id" value="{{$answer->id}}">
                                    <label for="answer_{{$answer->id}}" >{{$answer->answer}}</label>
                                </div>
                            @endforeach
                            <div class="display-error-{{$key}} text-center padding-top-bottom-5"></div>
                            <div class="justify-content-center display-flex">
                                <button class="btn-empty vote-button" type="submit">Проголосовать</button>
                            </div>
                        </form>
                    </div>
                    <div class="widget-footer">
                        <a href="#" id="view-answer-results-{{$key}}" data-num="{{$key}}"
                        data-url="{{route('question.view_answer',['id'=>$random_question->id])}}">
                            Посмотреть результаты</a>
                    </div>
                @endif
            @endforeach
        @endif

        @if(!empty($user_questions))
            @foreach($user_questions as $user_question)
                @php $answers = $general_helper->getUserAnswers($user_question->id); @endphp
                <div class="widget-title">{{$answers->question}}</div>
                <div id="view-results-response-answered" class="view-results-response">
                    @include('sidebar-widgets.answers-result')
                </div>     
            @endforeach
        @endif
    </div>
@endif



