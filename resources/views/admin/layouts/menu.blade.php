@php
$menu_name = $admin_helper->getMenuName();
@endphp

<ul class="sidebar-menu" data-widget="tree">
    <li class="header">ОСНОВНОЕ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'admin_panel') class="active" @endif><a href="{{route('admin.home')}}"><i class="fa fa-home"></i> <span>Главная панель</span></a></li>
    <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
        </ul>
    </li>

    <li class="header">ПОЛЬЗОВАТЕЛИ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'user') class="active" @endif><a href="{{route('admin.users')}}"><i class="fa fa-users"></i> <span>Список пользователей</span></a></li>
    @if($admin_helper->admin())
        <li @if($menu_name == 'user/role') class="active" @endif><a href="{{route('admin.users.role')}}"><i class="fa fa-users"></i> <span>Роли пользователей</span></a></li>
        <li @if($menu_name == 'user/gallery') class="active" @endif><a href="{{route('admin.users.gallery')}}"><i class="fa fa-image"></i> <span>Галлерея</span></a></li>
    @endif
    <li class="header">ФОРУМ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'forum') class="active" @endif><a href="{{route('admin.forum_sections')}}"><i class="fa fa-list"></i> <span>Разделы форума</span></a></li>
    <li @if($menu_name == 'forum/topic') class="active" @endif><a href="{{route('admin.forum_topic')}}"><i class="fa fa-list"></i> <span>Темы форума</span></a></li>

    <li class="header">Replay</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'replay') class="active" @endif><a href="{{route('admin.replay')}}"><i class="fa fa-film"></i> <span>Replays</span></a></li>
</ul>