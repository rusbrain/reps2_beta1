<div class="content-box user-account-box armor">
    <div class="user-account-box-title row">
        Доспехи
    </div>
    <div class="user-account-info-row">
        <span>
            <img src="{{route('home')}}/images/icons/mouse.png" alt="">
        </span>
        <span>{{$user->mouse ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>
            <img src="{{route('home')}}/images/icons/mousepad-icon.png" alt="">
        </span>
        <span>{{$user->mousepad ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>
            <img src="{{route('home')}}/images/icons/keyboard.png" alt="">
        </span>
        <span>{{$user->keyboard ?? 'не указано'}}</span>
    </div>
    <div class="user-account-info-row">
        <span>
            <img src="{{route('home')}}/images/icons/headphones.png" alt="">
        </span>
        <span>{{$user->headphone ?? 'не указано'}}</span>
    </div>
</div><!-- close div /.content-box -->