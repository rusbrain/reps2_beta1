@php
$menu_name = $admin_helper->getMenuName();
@endphp

<ul class="sidebar-menu" data-widget="tree">

    <li class="header">ОБЩЕЕ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'admin_panel') class="active" @endif><a href="{{route('admin.home')}}"><i class="fa fa-home"></i> <span>Главная панель</span></a></li>
    <li @if($menu_name == 'country') class="active" @endif><a href="{{route('admin.country')}}"><i class="fa fa-map-signs"></i> <span>Страны</span></a></li>
    <li @if($menu_name == 'question') class="active" @endif><a href="{{route('admin.question')}}"><i class="fa fa-question-circle"></i> <span>Опросы</span></a></li>
    <li @if($menu_name == 'file') class="active" @endif><a href="{{route('admin.file')}}"><i class="fa fa-files-o"></i> <span>Файлы</span></a></li>

    <li class="header">ПОЛЬЗОВАТЕЛИ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'user') class="active" @endif><a href="{{route('admin.users')}}"><i class="fa fa-users"></i> <span>Список пользователей</span></a></li>
    @if($admin_helper->admin())
        <li @if($menu_name == 'user/role') class="active" @endif><a href="{{route('admin.users.role')}}"><i class="fa fa-users"></i> <span>Роли пользователей</span></a></li>
    @endif
    <li @if($menu_name == 'user/gallery') class="active" @endif><a href="{{route('admin.users.gallery')}}"><i class="fa fa-image"></i> <span>Галерея</span></a></li>

    <li class="header">ФОРУМ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'forum') class="active" @endif><a href="{{route('admin.forum_sections')}}"><i class="fa fa-list"></i> <span>Разделы форума</span></a></li>
    <li @if($menu_name == 'forum/topic') class="active" @endif><a href="{{route('admin.forum_topic')}}"><i class="fa fa-list"></i> <span>Темы форума</span></a></li>

    <li class="header">Replay</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'replay') class="active" @endif><a href="{{route('admin.replay')}}"><i class="fa fa-film"></i> <span>Replays</span></a></li>
    <li @if($menu_name == 'replay/map') class="active" @endif><a href="{{route('admin.replay.map')}}"><i class="fa fa-map-o"></i> <span>Карты</span></a></li>
    <li @if($menu_name == 'replay/type') class="active" @endif><a href="{{route('admin.replay.type')}}"><i class="fa fa-object-group"></i> <span>Типы Replay</span></a></li>
</ul>