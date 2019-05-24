<div class="content-box user-account-box info">
    <div class="user-account-box-title row">
        Информация
    </div>
    <div class="user-account-info-row">
        <span>Темы:</span>
        <a href="{{route('user.forum_topic',['id' => $user->id])}}">
            <span class="color-blue text-bold">{{$user->topics_count}}</span>
        </a>
    </div>
    <div class="user-account-info-row">
        <span>Посты:</span>
        <a href="{{route('user.user_comments', ['id' => $user->id])}}">
            <span class="color-blue text-bold">{{$user->comments_count}}</span>
        </a>
    </div>
    <div class="user-account-info-row">
        <span>Госу реплеи:</span>
        <a href="{{route('user.gosu_replay', ['id' => $user->id])}}">
            <span class="color-blue text-bold">{{$user->gosu_replay_count}}</span>
        </a>
    </div>
    <div class="user-account-info-row">
        <span>Пользовательские реплеи:</span>
        <a href="{{route('user.user_replay',['id' => $user->id])}}">
            <span class="color-blue text-bold">{{$user->replay_count}}</span>
        </a>

    </div>
    {{--<div class="user-account-info-row">--}}
        {{--<span>Посты к реплеям:</span>--}}
        {{--<span class="color-blue text-bold">{{$user->replay_comments_count}}</span>--}}
    {{--</div>--}}
</div><!-- close div /.content-box -->