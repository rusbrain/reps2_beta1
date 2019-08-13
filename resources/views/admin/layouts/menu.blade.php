@php
$menu_name = $admin_helper->getMenuName();
$general = ($menu_name == 'admin_panel' || $menu_name == 'country' || $menu_name == 'question' || $menu_name == 'file') ? true :false;
$user = ($menu_name == 'user' || $menu_name == 'user/role' || $menu_name == 'user/gallery' || $menu_name == 'user/activity-log') ? true :false;
$forum = ($menu_name == 'forum' || $menu_name == 'forum/topic') ? true :false;
$replay = ($menu_name == 'replay' || $menu_name == 'replay/map' || $menu_name == 'replay/type') ? true :false;
$stream = ($menu_name == 'stream' || $menu_name == 'stream/header' || $menu_name == 'stream/settings') ? true :false;
$chat = ($menu_name == 'chat' || $menu_name == 'chat/smiles' || $menu_name == 'chat/pictures' || $menu_name == 'chat/pictures/category') ? true :false;
$footer = ($menu_name == 'footer' || $menu_name == 'footer/customurl') ? true :false;
$banner = ($menu_name == 'banner') ? true :false;
$dbbackup = ($menu_name == 'dbbackup') ? true :false;
@endphp

<ul class="sidebar-menu" data-widget="tree">
    {{-- General --}}
    @can('AdminAccess')
        <li class="treeview {{ $general ? 'active' : ''}}">
            <a href="#">
                <span>ОБЩЕЕ</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu  {{ $general ? 'menu-open' : ''}}">
                <li @if($menu_name == 'admin_panel') class="active" @endif><a href="{{route('admin.home')}}"><i class="fa fa-home"></i> <span>Главная панель</span></a></li>
                @can('NormalAdminAcess')
                    <li @if($menu_name == 'country') class="active" @endif><a href="{{route('admin.country')}}"><i class="fa fa-map-signs"></i> <span>Страны</span></a></li>
                    <li @if($menu_name == 'question') class="active" @endif><a href="{{route('admin.question')}}"><i class="fa fa-question-circle"></i> <span>Опросы</span></a></li>
                    <li @if($menu_name == 'file') class="active" @endif><a href="{{route('admin.file')}}"><i class="fa fa-files-o"></i> <span>Файлы</span></a></li>
                @endcan
            </ul>
        </li>
        @can('NormalAdminAcess')
            {{-- Users --}}
            <li class="treeview {{ $user ? 'active' : ''}}">
                <a href="#">
                    <span>ПОЛЬЗОВАТЕЛИ</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu  {{ $user ? 'menu-open' : ''}}">
                    <!-- Optionally, you can add icons to the links -->
                    <li @if($menu_name == 'user') class="active" @endif><a href="{{route('admin.users')}}"><i class="fa fa-users"></i> <span>Список пользователей</span></a></li>
                    @if($admin_helper->superadmin())
                        <li @if($menu_name == 'user/role') class="active" @endif><a href="{{route('admin.users.role')}}"><i class="fa fa-users"></i> <span>Роли пользователей</span></a></li>
                    @endif
                    <li @if($menu_name == 'user/gallery') class="active" @endif><a href="{{route('admin.users.gallery')}}"><i class="fa fa-image"></i> <span>Галерея</span></a></li>
                    <li @if($menu_name == 'user/activity-log') class="active" @endif><a href="{{route('admin.user.activity-log')}}"><i class="fa fa-history"></i> <span>Лог активности</span></a></li>

                </ul>
            </li>

            {{-- Stream --}}
            <li class="treeview {{ $stream ? 'active' : ''}}">
                <a href="#">
                    <span>Stream</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu  {{ $stream ? 'menu-open' : ''}}">
                    <li @if($menu_name == 'stream/settings') class="active" @endif><a href="{{route('admin.stream.setting')}}"><i class="fa fa-gear"></i> <span>Hастройки</span></a></li>
                    <li @if($menu_name == 'stream') class="active" @endif><a href="{{route('admin.stream')}}"><i class="fa fa-film"></i> <span>Streams</span></a></li>
                    <li @if($menu_name == 'stream/header') class="active" @endif><a href="{{route('admin.stream.header')}}"><i class="fa fa-header"></i> <span>Заголовок</span></a></li>
                </ul>
            </li>
        @endcan

        {{-- Forum --}}
        <li class="treeview {{ $forum ? 'active' : ''}}">
            <a href="#">
                <span>ФОРУМ</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu  {{ $forum ? 'menu-open' : ''}}">
            <!-- Optionally, you can add icons to the links -->
                <li @if($menu_name == 'forum') class="active" @endif><a href="{{route('admin.forum_sections')}}"><i class="fa fa-list"></i> <span>Разделы форума</span></a></li>
                <li @if($menu_name == 'forum/topic') class="active" @endif><a href="{{route('admin.forum_topic')}}"><i class="fa fa-list"></i> <span>Темы форума</span></a></li>
            </ul>
        </li>

        {{-- Replay --}}
        <li class="treeview {{ $replay ? 'active' : ''}}">
            <a href="#">
                <span>Replay</span>
                <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu  {{ $replay ? 'menu-open' : ''}}">
                <!-- Optionally, you can add icons to the links -->
                <li @if($menu_name == 'replay') class="active" @endif><a href="{{route('admin.replay')}}"><i class="fa fa-film"></i> <span>Replays</span></a></li>
                <li @if($menu_name == 'replay/map') class="active" @endif><a href="{{route('admin.replay.map')}}"><i class="fa fa-map-o"></i> <span>Карты</span></a></li>
                <li @if($menu_name == 'replay/type') class="active" @endif><a href="{{route('admin.replay.type')}}"><i class="fa fa-object-group"></i> <span>Типы Replay</span></a></li>
            </ul>
        </li>

        @can('NormalAdminAcess')
            {{-- Chat --}}
            <li class="treeview {{ $chat ? 'active' : ''}}">
                <a href="#">
                    <span>Болтаем</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu {{ $chat ? 'menu-open' : ''}}">
                    <li @if($menu_name == 'chat') class="active" @endif><a href="{{route('admin.chat')}}"><i class="fa fa-commenting"></i> <span>Cообщения чата</span></a></li>
                    <li @if($menu_name == 'chat/smiles') class="active" @endif><a href="{{route('admin.chat.smiles')}}"><i class="fa fa-smile-o"></i> <span>Улыбки</span></a></li>
                    <li @if($menu_name == 'chat/pictures') class="active" @endif><a href="{{route('admin.chat.pictures')}}"><i class="fa fa-file-image-o"></i> <span>Изображение</span></a></li>
                    <li @if($menu_name == 'chat/pictures/category') class="active" @endif><a href="{{route('admin.chat.pictures.category')}}"><i class="fa fa-file-image-o"></i> <span>Изображение категория</span></a></li>
                </ul>
            </li>
            {{-- Basement / Footer --}}
            <li class="treeview {{ $footer ? 'active' : ''}}">
                <a href="#">
                    <span>Подвал/Footer</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu  {{ $footer ? 'menu-open' : ''}}">
                    <!-- Optionally, you can add icons to the links -->
                    <li @if($menu_name == 'footer') class="active" @endif><a href="{{route('admin.footer')}}"><i class="fa fa-film"></i> <span>Подвал/Footer сайта</span></a></li>
                    <li @if($menu_name == 'footer/customurl') class="active" @endif><a href="{{route('admin.footer.customurl')}}"><i class="fa fa-film"></i> <span>Подвал/Footer Urls</span></a></li>
                </ul>
            </li>
            {{-- Banner --}}
            <li class="treeview {{ $banner ? 'active' : ''}}">
                <a href="#">
                    <span>Баннеры</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu  {{ $banner ? 'menu-open' : ''}}">
                    <li @if($menu_name == 'banner') class="active" @endif><a href="{{route('admin.banner')}}"><i class="fa fa-film"></i> <span>Баннеры</span></a></li>
                </ul>
            </li>
            {{-- Banner --}}
            @can('SuperAdminAccess')
                <li class="treeview {{ $dbbackup ? 'active' : ''}}">
                    <a href="#">
                        <span>DB Backup</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu  {{ $dbbackup ? 'menu-open' : ''}}">
                        <li @if($menu_name == 'dbbackup') class="active" @endif><a href="{{route('admin.dbbackup')}}"><i class="fa fa-database"></i> <span>Backup</span></a></li>                        
                    </ul>
                </li>
            @endcan
        @endcan   
    @endcan
</ul>
