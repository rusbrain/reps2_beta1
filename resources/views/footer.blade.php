@php
    $footer_urls = $general_helper->getFooterUrls();
    $footer_widgets = $general_helper->getFooterWidgets();
@endphp
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
                        @if($footer_widgets)
                            @foreach($footer_widgets as $footer_widget)
                                @if($footer_widget->position == 4)
                                    <div class="footer-title">
                                        <h2>{{$footer_widget->title}}</h2>
                                    </div>
                                    <div class="footer-info">
                                        {!! $footer_widget->text !!}
                                        <div>
                                            <img src="{{route('home')}}/images/icons/mail_icon.png" alt="">
                                            {{$footer_widget->email}}
                                        </div>
                                        <div>
                                            <img src="{{route('home')}}/images/icons/discord-logo-vector.png" alt="">
                                            {{$footer_widget->icq}}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
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
                                    <img src="{{route('home')}}/images/icons/discord-logo-vector.png" alt="">
                                    864-000
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="footer-title">
                    <h2>Пользовательский Urls:</h2>
                </div>
                <div class="footer-user-birthday-wrapper">
                    @if($footer_urls)
                        @foreach($footer_urls as $custom_url)
                            <a href="{{$custom_url->url}}" target="_blank"
                               class="footer-user-birthday"
                               title="{!! $custom_url->title !!}">{!! $custom_url->title !!}</a>
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
                2002-{{date('Y')}} Replay Cafe | 2018-{{date('Y')}} Reps2 | 1998-{{date('Y')}} StarCraft: Brood War by Blizzard Entertainment
           </div>
        </div>
    </div>
</section>