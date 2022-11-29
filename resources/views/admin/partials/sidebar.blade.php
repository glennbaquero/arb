<aside class="main-sidebar sidebar-dark-danger elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link bg-danger">
        @include('partials.brand')
    </a>

    <div class="sidebar">
        @if (auth()->check())
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ $self->renderAvatar() }}" class="img-circle elevation-2" style="width: 35px; height: 35px;">
                </div>
                <div class="info">
                    <a href="{{ route('admin.profiles.show') }}" class="d-block">
                        {{ $self->renderName() }}
                    </a>
                </div>
            </div>
        @endif

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.dashboard',
                    ]) }}">
                        <i class="nav-icon far fa-chart-bar"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @if ($self->hasAnyPermission(['admin.documents.crud']) || auth()->guard('admin')->user()->is_supervisor)
                <li class="nav-item">
                    <a href="{{ route('admin.documents.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.documents.index','admin.documents.show'
                    ]) }}">
                        <i class="nav-icon far fa-file-word"></i>
                        <p>
                            Documents
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                        'admin.reports.index'
                    ]) }}">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>
                            Generate Reports
                        </p>
                    </a>
                </li>

                @if ($self->hasAnyPermission(['admin.users.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.users.index','admin.users.create','admin.users.show',
                            'admin.supervisors.index','admin.supervisors.create','admin.supervisors.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                User Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.users.index','admin.users.create','admin.users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            @endif


                            @if ($self->hasAnyPermission(['admin.supervisors.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.supervisors.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.supervisors.index','admin.supervisors.create','admin.supervisors.show',
                                ]) }}">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p>
                                        Supervisors
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.pages.crud', 'admin.page-items.crud', 'admin.articles.crud', 'admin.faqs.crud', 'admin.announcements.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.pages.index','admin.pages.create','admin.pages.show',
                            'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                            'admin.articles.index','admin.articles.create','admin.articles.show',
                            'admin.faqs.index','admin.faqs.create','admin.faqs.show',
                            'admin.announcements.index','admin.announcements.create','admin.announcements.show',
                            'admin.about-us.index',
                            'admin.branches.index', 'admin.branches.create', 'admin.branches.show',
                            'admin.inquiries.index', 'admin.inquiries.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-feather"></i>
                            <p>
                                Content Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @if ($self->hasAnyPermission(['admin.faqs.crud']))
                             <li class="nav-item">
                                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.faqs.index','admin.faqs.create','admin.faqs.show',
                                ]) }}">
                                    <i class="nav-icon fas fa-question"></i>
                                    <p>
                                        FAQ
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.announcements.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.announcements.index','admin.announcements.create','admin.announcements.show',
                                ]) }}">
                                    <i class="nav-icon fas fa-bullhorn"></i>
                                    <p>
                                        Announcement
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.about-us.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.about-us.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.about-us.index',
                                ]) }}">
                                    <i class="nav-icon fas fa-address-card"></i>
                                    <p>
                                        About Us
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.branches.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.branches.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.branches.index', 'admin.branches.create', 'admin.branches.show',
                                ]) }}">
                                    <i class="nav-icon far fa-building"></i>
                                    <p>
                                        Branch/Offices
                                    </p>
                                </a>
                            </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.inquiries.crud']))
                            <li class="nav-item">
                                <a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                    'admin.inquiries.index', 'admin.inquiries.show',
                                ]) }}">
                                    <i class="nav-icon far fa-envelope"></i>
                                    <p>
                                        Inquiries
                                    </p>
                                </a>
                            </li>
                            @endif
                            
                            @if ($self->hasAnyPermission(['admin.page-items.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.page-items.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.page-items.index','admin.page-items.create','admin.page-items.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Page Items
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.admin-users.crud', 'admin.roles.crud', 'admin.users.crud', 'admin.activity-logs.crud']))
                    <li class="nav-header">Admin Management</li>
                @endif

                @if ($self->hasAnyPermission(['admin.admin-users.crud', 'admin.roles.crud']))
                    <li class="nav-item has-treeview {{ $checker->route->areOnRoutes([
                            'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                            'admin.roles.index', 'admin.roles.create', 'admin.roles.show',
                        ]) }}">
                        <a href="javascript:void(0)" class="nav-link">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>
                                Admin Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if ($self->hasAnyPermission(['admin.admin-users.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.admin-users.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.admin-users.index','admin.admin-users.create','admin.admin-users.show',
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Admins
                                        </p>
                                    </a>
                                </li>
                            @endif

                            @if ($self->hasAnyPermission(['admin.roles.crud']))
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                                        'admin.roles.index', 'admin.roles.create', 'admin.roles.show'
                                    ]) }}">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>
                                            Roles & Permissions
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($self->hasAnyPermission(['admin.activity-logs.crud']))
                    <li class="nav-item">
                        <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ $checker->route->areOnRoutes([
                            'admin.activity-logs.index',
                        ]) }}">
                            <i class="nav-icon fa fa-file-alt"></i>
                            <p>
                                Activity Logs
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

    </div>
</aside>