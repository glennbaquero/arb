@extends('guest.landing')

@section('meta:title', 'Login')

@section('content')

<p class="login-box-msg">Sign in to start your session</p>

<div class="row">
    <!-- /.col -->
    <div class="col-md-12 mb-3">
        <a href="{{ route('admin.login') }}" class="btn btn-primary btn-block">Sign in as Admin</a>
    </div>

    <div class="col-md-12">
        <a href="{{ route('web.login') }}" class="btn btn-outline-primary btn-block">Sign in as User</a>
    </div>
    <!-- /.col -->
</div>

@endsection