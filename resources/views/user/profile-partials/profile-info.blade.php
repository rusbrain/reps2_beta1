<div class="content-box user-account-box info">
    <div class="user-account-box-title row">
        Информация
    </div>
    <div class="user-account-info-row">
        <span>Темы:</span>
        <span class="color-blue text-bold">{{$user->topics_count}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Посты:</span>
        <span class="color-blue text-bold">{{$user->comments_count}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Госу реплеи:</span>
        <span class="color-blue text-bold">{{$user->gosu_replay_count}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Пользовательские реплеи:</span>
        <span class="color-blue text-bold">{{$user->replay_count}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Посты к реплеям:</span>
        <span class="color-blue text-bold">{{$user->replay_comments_count}}</span>
    </div>
</div><!-- close div /.content-box -->