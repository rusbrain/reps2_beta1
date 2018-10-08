
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">GENERAL</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($admin_helper->getMenuName() == 'admin_panel') class="active" @endif><a href="{{route('admin.home')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
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
    <li class="header">USERS</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($admin_helper->getMenuName() == 'user') class="active" @endif><a href="{{route('admin.users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
    <li class="header">FORUM</li>
    <!-- Optionally, you can add icons to the links -->
    <li @if($admin_helper->getMenuName() == 'forum') class="active" @endif><a href="{{route('admin.forum_sections')}}"><i class="fa fa-list"></i> <span>Forum sections</span></a></li>
</ul>