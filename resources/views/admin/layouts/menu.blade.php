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
    <li @if($menu_name == 'user/role') class="active" @endif><a href="{{route('admin.users.role')}}"><i class="fa fa-users"></i> <span>Роли пользователей</span></a></li>

    <li class="header">ФОРУМ</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'forum') class="active" @endif><a href="{{route('admin.forum_sections')}}"><i class="fa fa-list"></i> <span>Разделы форума</span></a></li>

    <li class="header">Replay</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($menu_name == 'replay/gosu') class="active" @endif><a href="{{route('admin.replay.gosu')}}"><i class="fa fa-film"></i> <span>Gosu</span></a></li>
    @if($admin_helper->admin())
        <li @if($menu_name == 'replay/users') class="active" @endif><a href="{{route('admin.replay.users')}}"><i class="fa fa-film"></i> <span>Пользовательские</span></a></li>
    @endif
</ul>