<div class="widget-navigation">
    <ul id="menu" class="navigation">
        <li class="active">
            <a href="\" class="menu-link">Главная</a>
        </li>
        <li>
            <a href="{{route('forum.index')}}" class="has-arrow menu-link" aria-expanded="false">Форум</a>
            @if($general_helper->getGeneralSectionsForum())
                <ul class="submenu">
                    @foreach($general_helper->getGeneralSectionsForum() as $item)
                        <li>
                            <a href="{{route('forum.section.index',['name' => $item->name])}}" class="submenu-menu-link">{{$item->title}}</a>
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
                    @if($general_helper->getReplayTypes())
                        <ul class="sub submenu">
                            @foreach($general_helper->getReplayTypes() as $replayType)
                                <li>
                                    <a href="{{route('replay.gosus_type', ['type' => $replayType->name])}}" class="submenu-menu-link">{{$replayType->title}}</a>
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