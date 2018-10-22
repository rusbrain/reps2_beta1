<div class="sidebar-right">
    <div class="sidebar-widget random-image">
        <div class="sidebar-widget-title">Случайные картинки</div>
        <div class="sidebar-widget-content">
            @if(!empty($random_img))
                @foreach($random_img as $img)
                    <img src="{{$img['file']['link']}}" alt="">
                @endforeach
            @else
                <p class="sidebar-widget-no-results">There is no Random images</p>
            @endif
        </div>
    </div>


    @if(!empty($random_question))
        <div class="sidebar-widget">
            <div class="sidebar-widget-title">Случайные вопрос</div>
            <div class="sidebar-widget-content">
                {{--                {{dd($random_question)}}--}}
                <p class="sidebar-widget-subtitle">{{$random_question->question}}</p>
                @if(!empty($random_question->answers))
                    <form action="{{route('question.set_answer',['id' => $random_question->id])}}" method="post">
                        @csrf
                        @foreach($random_question->answers as $answer)
                            <div class="form-group">
                                <input type="radio" id="answer_{{$answer->id}}" value="{{$answer->id}}">
                                <label for="answer_0">{{$answer->answer}}</label>
                            </div>
                        @endforeach
                        <button type="submit">Vote</button>
                    </form>
                    <a class="view-results" href="{{route('question.view_answer',['id' => $random_question->id])}}">View
                        results</a>
                @endif
            </div>
        </div>
    @endif


    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Новые пользователи</div>
        <div class="sidebar-widget-content">
            @if(!empty($new_users))
                @foreach($new_users as $new_user)
                    <div>
                        <span>#{{$new_user->id}}</span>
                        <span class="flag-icon flag-icon-{{mb_strtolower($new_user->country->code)}}"></span>
                        <span>{{$new_user->name}}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Юзерские реплеи</div>
        <div class="sidebar-widget-content">

            @if(!empty($last_user_replay))
                @foreach($last_user_replay as $replay)
                    <div class="replays-wrapper">
                        <a class="replay"
                           href="{{route('replay.get',['id' => $replay->id])}}"><span>{{$replay->title}}</span><span
                                    class="qty-downloaded">{{$replay->downloaded}}</span></a>
                    </div>
                @endforeach
                <a class="view-results" href="{{route('replay.users')}}">Ещё</a>
            @else
                <p class="sidebar-widget-no-results">There are no User's replays</p>
            @endif
        </div>
    </div>
</div>