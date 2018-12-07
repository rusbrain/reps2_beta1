@php
    $random_question = $general_helper->getRandomQuestion();
    $last_user_replays = $general_helper->getLastUserReplay();
@endphp

@if(isset($random_question) && !empty($random_question))
    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Голосование</div>
        <div class="sidebar-widget-content ">
            <div class="sidebar-widget-subtitle">{{$random_question->question}}</div>
            <div id="view-results-response" class="view-results-response">
                @if(isset($random_question->answers) && !empty($random_question->answers))
                    <form action="{{route('question.set_answer',['id' => $random_question->id])}}" id="vote-form"
                          method="post">
                        @csrf
                        <div id="vote-form-error"></div>
                        @foreach($random_question->answers as $answer)
                            <div class="form-group">
                                <input type="radio" id="answer_{{$answer->id}}" value="{{$answer->id}}"
                                       name="answer_id">
                                <label for="answer_{{$answer->id}}">{{$answer->answer}}</label>
                            </div>
                        @endforeach
                        <button type="submit" class="vote-button btn btn-primary">Vote</button>
                    </form>
                    <a class="view-results"
                       id="view-answer-results"
                       data-url="{{route('question.view_answer',['id'=>$random_question->id])}}"
                       href="#">View results</a>
                @endif
            </div>
        </div>
    </div>
@endif

@if($general_helper->getLastForum())
    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Основные темы форума</div>
        <div class="sidebar-widget-content">
            @foreach($general_helper->getLastForum() as $forum)
                <div class="sidebar-widget-forum-section">
                    <div class="forum-section-title">
                        <a href="{{route('forum.section.index',['name' => $forum->name])}}">{{$forum->title}}:</a>
                    </div>
                    <div class="forum-section-content">
                        @foreach($forum->topics as $item => $topic)
                            <div class="topic-wrapper">
                                <p class="topic-title">
                                    <a href="{{route('forum.topic.index',['id'=>$topic->id])}}">
                                        <span>{{$topic->title}}</span> <span>({{$topic->comments_count}})</span>
                                    </a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
<div class="sidebar-widget">
    <div class="sidebar-widget-title">Gosu реплеи</div>
    <div class="sidebar-widget-content">
        @if($replays)
            @foreach($replays as $replay)
                <div class="replays-wrapper">
                    <a class="replay"
                       href="{{route('replay.get',['id' => $replay->id])}}">
                        <span class="name">{{$replay->title}}</span>
                        <span class="qty-downloaded">{{$replay->downloaded}}</span>
                    </a>
                </div>
            @endforeach
            <a class="view-results" href="{{route('replay.users')}}">Ещё</a>
        @else
            <p class="sidebar-widget-no-results">В данный момент нет Госу реплеев</p>
        @endif
    </div>
</div>
<div class="sidebar-widget">
    <div class="sidebar-widget-title">Юзерские реплеи</div>
    <div class="sidebar-widget-content">
        @if(!empty($last_user_replays))
            @foreach($last_user_replays as $replay)
                <div class="replays-wrapper">
                    <a class="replay"
                       href="{{route('replay.get',['id' => $replay->id])}}">
                        <span class="name">{{$replay->title}}</span>
                        <span class="qty-downloaded">{{$replay->downloaded}}</span>
                    </a>
                </div>
            @endforeach
            <a class="view-results" href="{{route('replay.users')}}">Ещё</a>
        @else
            <p class="sidebar-widget-no-results">There are no User's replays</p>
        @endif
    </div>
</div>