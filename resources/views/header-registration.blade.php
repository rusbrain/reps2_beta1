<div class="row header">
    <div class="col">
        <a href="/"><img src="/images/header.gif" alt=""></a>
    </div>
    <div class="col">
        <div class="header-social">
            <a href="#"><i class="fab fa-facebook-square"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-vk"></i></a>
        </div>
    </div>

    @if(!Auth::user())
        <div class="col-3">

        </div>
    @else
        <div class="col-3 header-profile">
            <p class="hello">Hello {{Auth::user()->name}}</p>
            <a class="profile-link" href="{{route('edit_profile')}}">Профиль пользователя</a>
            <a class="profile-link" href="{{route('edit_profile')}}">Выход</a>
        </div>
    @endif
</div>