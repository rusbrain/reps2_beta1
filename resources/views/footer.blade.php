@php $last_news = $general_helper->getLastNewsFooter(); @endphp
<section class="section-footer-top">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="/">
                    <img src="{{route('home')}}/images/logo.png" alt="" class="margin-bottom-20">
                </a>
                <div>
                    Everything about Starcraft Broodwar world Pro-gaming
                </div>
            </div>
            <div class="col">
                <div class="footer-title">
                    <h2>Наши именинники:</h2>
                </div>
                <div class="footer-user-birthday-wrapper">
                    @if($general_helper->getBirthdayUsers())
                        @foreach($general_helper->getBirthdayUsers() as $user)
                            @php
                                $user_birthday  = new \Carbon\Carbon($user->birthday);
                                $now = new Carbon\Carbon(\Carbon\Carbon::now()->format('Y-m-d'));
                            @endphp

                            <a href="{{route('user_profile',['id' => $user->id])}}"
                               class="footer-user-birthday"
                               title="{{$user->name}} ({{$user_birthday->diff($now)->format('%y')}})">{{$user->name}}
                                ({{$user_birthday->diff($now)->format('%y')}})</a>

                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-title">
                            <h2>Меню:</h2>
                        </div>
                        <div>
                            <ul class="footer-menu">
                                <li>
                                    <a href="/">Главная</a>
                                </li>
                                <li>
                                    <a href="{{route('forum.index')}}">Форум</a>
                                </li>
                                <li>
                                    <a href="{{route('replay.gosus')}}">Госу реплеи</a>
                                </li>
                                <li>
                                    <a href="{{route('replay.users')}}">Реплеи</a>
                                </li>
                                <li>
                                    <a href="{{route('news')}}">Новости</a>
                                </li>
                                <li class="display-none">
                                    <a href="">Топ юзеров</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="footer-title">
                            <h2>Info and legal information</h2>
                        </div>
                        <div class="footer-info">
                            По вопросам работы сайта, сотрудничества, ньюсмейкерства, спонсорства и размещения
                            рекламы, обращайтесь:
                            <div>
                                <img src="{{route('home')}}/images/icons/mail_icon.png" alt="">
                                evil-2002@yandex.ru
                            </div>
                            <div>
                                <img src="{{route('home')}}/images/icons/icq.png" alt="">
                                864-000
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="footer-title">
                    <h2>Последние новости:</h2>
                </div>
                <div class="footer-user-birthday-wrapper">
                    @if($last_news)
                        @foreach($last_news as $last_forum)
                            <a href="{{route('forum.topic.index',['id'=>$last_forum->id])}}"
                               class="footer-user-birthday"
                               title="{!! $last_forum->title??'название новости' !!}">{!! $last_forum->title??'название новости' !!}</a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row ">
            <div class="col-md-12 footer-low">
                © 2002-{{date('Y')}} Replay Cafe All Right Reserved
                I © 2003-{{date('Y')}} REPLAY CAFE ENGINE / v.4.7.
                I © 1998-{{date('Y')}} StarCraft, StarCraft:Brood War by Blizzard Ent.
            </div>
        </div>
    </div>
</section>