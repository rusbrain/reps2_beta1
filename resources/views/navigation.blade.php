<nav class="navbar row navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="\">Главная <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="{{route('forum.index')}}" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Форум
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @if($general_helper->getGeneralSectionsForum())
                        @foreach($general_helper->getGeneralSectionsForum() as $item)
                            <li>
                                <a class="dropdown-item"
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Replays
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{route('replay.users')}}" class="dropdown-item">Реплеи Юзеров <b
                                    class="caret"></b></a>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="{{route('replay.gosus')}}" class="dropdown-item dropdown-toggle"
                           data-toggle="dropdown">Госу реплеи <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            @if($general_helper->getReplayTypes())
                                @foreach($general_helper->getReplayTypes() as $replayType)
                                    <li>
                                        <a class="dropdown-item"
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
                <a class="nav-link" href="">Новости</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" id="search-form">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>