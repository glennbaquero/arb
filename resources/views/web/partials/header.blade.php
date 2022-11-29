<nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-danger">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="javascript:void(0)"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link" href="{{ route('web.notifications.index') }}">
                <i class="fa fa-bell mr-2 text-white"></i>
                <count-listener
                class="badge-warning navbar-badge text-white"
                fetch-url="{{ route('web.counts.fetch.notifications') }}"
                event="update-notification-count"
                ></count-listener>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link text-white" href="{{ route('web.logout') }}">Logout</a>
        </li>

    </ul>
</nav>
