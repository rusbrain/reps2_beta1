@php
    $random_question = $general_helper->getRandomQuestion();
@endphp
@if(!empty($random_question))
    <div class="widget-wrapper">
        <div class="widget-header">Голосование</div>
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
    </div>
@endif