@extends('web.auth-master')

@section('meta:title', 'Login')

@section('content')

<div class="login-box-msg"><p>Sign in to start your session</p></div>

<div class="row">
    <div class="col-sm-12 col-md-12 form-group">
        <a href="{{ route('web.facebook.login') }}" class="btn btn-default btn-block text-white" style="background: #3b5998;">
            <i class="fab fa-facebook-f mr-2"></i>
            Sign In with Facebook
        </a>
    </div>
</div>

<form action="{{ route('web.login') }}" method="POST">
    @csrf

    <div class="form-group has-feedback">
         <input id="email" type="text" class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="identity" value="{{ old('username') ?: old('email') }}" placeholder="E-mail or Username" required autofocus>

        @if ($errors->has('username') || $errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group has-feedback">
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="mb-3">
        <a class="float-right" href="{{ route('web.password.request') }}">I forgot my password</a><br>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 form-group">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </div>

        <div class="col-sm-12 col-md-12 form-group">
            <a href="{{ route('web.register') }}" class="btn btn-default btn-block">Sign Up</a>
        </div>
    </div>
</form>

@endsection