<div class="content-box user-account-box contacts">
    <div class="user-account-box-title row">
        Контакты
    </div>
    <div class="user-account-info-row ">
        <span class="">Е-mail:</span>
        <span>{{$user->email ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Сайт:</span>
        <a href="">{{$user->homepage ?? 'не указано'}}</a>
    </div>
    <div class="user-account-info-row">
        <span>ICQ:</span>
        <span>{{$user->isq ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Skype:</span>
        <span>{{$user->skype ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Подпись:</span>
        <span>{{$user->signature ?? 'не указано'}}</span>
    </div>
</div><!-- close div /.content-box -->