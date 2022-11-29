<!DOCTYPE html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>

    @include('partials.meta-tags')
    @include('admin.partials.styles')

</head>
<body class="sidebar-mini layout-fixed">
	
    <div id="app" class="wrapper">

        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        
        @yield('content')

        @include('admin.partials.footer')

    </div>

    @include('partials.script-tags')

</body>
</html>