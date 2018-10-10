<div class="sidebar-right">
    {{--{{dd($random_img)}}--}}
    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Случайные картинки</div>
        <div class="sidebar-widget-content">
            @if(!empty($random_img))
                @foreach($random_img as $img)
                    <img src="/{{$img->file->link}}" alt="">
                @endforeach
            @endif
        </div>
    </div>

    {{--{{dd($random_question)}}--}}
    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Случайные вопрос</div>
        <div class="sidebar-widget-content">
            @if(!empty($random_question))
                <p>{{$random_question->question}}</p>
            @endif
        </div>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Новые пользователи</div>
        <div class="sidebar-widget-content">
            @if(!empty($new_users))
                @foreach($new_users as $new_user)
                    <div>
                        <span>#{{$new_user->id}}</span>
                        <span>{{$new_user->name}}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="sidebar-widget">
        <div class="sidebar-widget-title">Последние пользовательские реплаи</div>
        <div class="sidebar-widget-content">
            @if(!empty($last_user_replay))
                @foreach($last_user_replay as $replay)
                    <div>
                        <a href="{{}}">#{{}}</a>
                        <span>{{}}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>