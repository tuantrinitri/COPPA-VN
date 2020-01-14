@extends('layout_auth')

@section('site_title', 'Login')

@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href="{{ route('home') }}"><b>COPPA</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <form action="{{ route('post-login') }}" method="post">
        {{ csrf_field() }}
        @if ($errors->has('loginfaild'))
              <small class="text-danger">{{ $errors->first('loginfaild') }}</small>
          @endif
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        @if ($errors->has('username'))
            <small class="text-danger">{{ $errors->first('username') }}</small>
        @endif
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <small class="text-danger">{{ $errors->first('password') }}</small>
        @endif
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection