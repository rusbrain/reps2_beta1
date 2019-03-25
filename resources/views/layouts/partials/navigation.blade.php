@php
    /**@var \App\ForumSection[] $sections*/
    $sections = $general_helper->getGeneralSectionsForum();
    $replays_types = $general_helper->getReplayTypes();
@endphp
<div class="widget-navigation">
    <ul id="menu" class="navigation">
        <li class="active">
            <a href="\" class="menu-link">Главная</a>
        </li>
        <li>
            <a href="{{route('forum.index')}}" class="has-arrow menu-link" aria-expanded="false">Форум</a>
            @if($sections)
                <ul class="submenu">
                    @foreach($sections as $section)
                        <li>
                            <a href="{{route('forum.section.index',['name' => $section->name])}}" class="submenu-menu-link">{{$section->title}}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
        <li>
            <a href="#" class="has-arrow menu-link" aria-expanded="false">Реплеи</a>
            <ul class="submenu">
                <li>
                    <a href="{{route('replay.users')}}" class="submenu-menu-link">Реплеи Юзеров</a>
                </li>
                <li>
                    <a href="{{route('replay.gosus')}}" class="has-arrow submenu-menu-link" aria-expanded="false">Госу
                        реплеи</a>
                    @if($replays_types)
                        <ul class="sub submenu">
                            @foreach($replays_types as $replay_type)
                                <li>
                                    <a href="{{route('replay.gosus_type', ['type' => $replay_type->name])}}" class="submenu-menu-link">{{$replay_type->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        </li>
        <li class="">
            <a href="{{route('news')}}" class="menu-link">Новости</a>
        </li>
        <li>
            <a href="#" class="menu-link display-none">Контакты</a>
        </li>
    </ul>
</div><!-- close div /.widget-navigation-->