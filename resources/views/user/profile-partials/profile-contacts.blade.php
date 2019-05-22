<div class="content-box user-account-box contacts">
    <div class="user-account-box-title row">
        Контакты
    </div>
    <div class="user-account-info-row ">
        <span class="">Е-mail:</span>
        @if(Auth::id() == $user->id)
            <span class="color-blue text-bold">{{$user->email ?? 'не указано'}}</span>
        @else
            <span class="color-blue text-bold">{{'Скрыт' ?? 'не указано'}}</span>
        @endif
    </div>
    <div class="user-account-info-row">
        <span>Сайт:</span>
        @if(!$general_helper->checkUserLink($user->homepage))
            <span class="color-blue text-bold">{{$user->homepage ?? 'не указано'}}</span>
        @else
            <a href="{{$general_helper->checkUserLink($user->homepage)}}">{{$user->homepage}}</a>
        @endif
    </div>
    <div class="user-account-info-row">
        <span>ICQ:</span>
        <span class="color-blue text-bold">{{$user->isq ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Skype:</span>
        <span class="color-blue text-bold">{{$user->skype ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>Подпись:</span>
        <span class="color-blue text-bold">{!! $user->signature ?? 'не указано' !!}</span>
    </div>
</div><!-- close div /.content-box -->