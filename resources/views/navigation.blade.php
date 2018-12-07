<ul class="navbar-nav mr-auto">
    <li class="nav-item active">
        <a class="nav-link" href="\">Главная <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('forum.index')}}" > Форум </a>
        <ul class="">
            @if($general_helper->getGeneralSectionsForum())
                @foreach($general_helper->getGeneralSectionsForum() as $item)
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{route('forum.section.index',['name' => $item->name])}}">
                            {{$item->title}}
                        </a>
                    </li>
                @endforeach
            @else
                <li>
                    В данные момент основные разделы форума не определены
                </li>
            @endif
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" > Replays </a>
        <ul class="">
            <li class="nav-item">
                <a href="{{route('replay.users')}}" class="nav-link">Реплеи Юзеров <b
                            class="caret"></b></a>
            </li>
            <li class="nav-item">
                <a href="{{route('replay.gosus')}}" class="nav-link" >Госу реплеи </a>
                <ul class="">
                    @if($general_helper->getReplayTypes())
                        @foreach($general_helper->getReplayTypes() as $replayType)
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{route('replay.gosu_type', ['type' => $replayType->name])}}">
                                    {{$replayType->title}}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{route('news')}}">Новости</a>
    </li>
</ul>