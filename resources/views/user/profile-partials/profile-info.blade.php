<div class="content-box user-account-box info">
    <div class="user-account-box-title row">
        Информация
    </div>
    <div class="user-account-info-row">
        <span>Темы:</span>
        <a href="">{{$user->topics_count}}</a>
    </div>
    <div class="user-account-info-row">
        <span>Посты:</span>
        <a href="">{{$user->comments_count}}</a>
    </div>
    <div class="user-account-info-row">
        <span>Госу реплеи:</span>
        <a href="">{{$user->gosu_replay_count}}</a>
    </div>
    <div class="user-account-info-row">
        <span>Пользовательские реплеи:</span>
        <a href="">{{$user->replay_count}}</a>
    </div>
    <div class="user-account-info-row">
        <span>Посты к реплеям:</span>
        <a href="">{{$user->replay_comments_count}}</a>
    </div>
</div><!-- close div /.content-box -->