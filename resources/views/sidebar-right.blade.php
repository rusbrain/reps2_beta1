<div class="sidebar-right">
    <div class="sidebar-widget random-image">
        <div class="sidebar-widget-title">Банеры</div>
        <div class="sidebar-widget-content">
            @if($general_helper->getRandomBanner())
                {{--{{dd($general_helper->getRandomBanner())}}--}}
                @php $banner = $general_helper->getRandomBanner(); @endphp
                <a href="#" class="random-banner">
                    <img src="{{$banner->file->link}}" alt="">
                </a>
            @else
                <p class="sidebar-widget-no-results">В данный момент банеров нет</p>
            @endif

        </div>
    </div>

    <div class="sidebar-widget random-image">
        <div class="sidebar-widget-title">Случайные картинки</div>
        <div class="sidebar-widget-content">
            @if(!empty($general_helper->getRandomImg()))
                @foreach($general_helper->getRandomImg() as $img)
                    <a href="{{route('gallery.view', ['id'=>$img['id']])}}">
                        <img src="{{$img['file']['link']}}" alt="">
                    </a>
                @endforeach
            @else
                <p class="sidebar-widget-no-results">В данный момент случайных картинок нет</p>
            @endif
        </div>
    </div>
    <?php $random_question = $general_helper->getRandomQuestion() ?>
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

    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Новые пользователи</div>
        <div class="sidebar-widget-content">
            @if(!empty($general_helper->getNewUsers()))
                @foreach($general_helper->getNewUsers() as $new_user)
                    <div>
                        <a href="{{route('user_profile',['id'=>$new_user->id])}}">
                            <span>#{{$new_user->id}}</span>
                            <span class="flag-icon flag-icon-{{mb_strtolower($new_user->country->code)}}"></span>
                            <span class="name">{{$new_user->name}}</span>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Юзерские реплеи</div>
        <div class="sidebar-widget-content">
            @if(!empty($general_helper->getLastUserReplay()))
                @foreach($general_helper->getLastUserReplay() as $replay)
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
</div>