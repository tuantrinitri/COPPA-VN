@extends('layout_common')

@section('site_title', 'Users')

@section('content')
<style>
  td{
    vertical-align: middle !important;
  }
</style>
<!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Add user</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="{{ route('post-add-user') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                  <label>Username</label>
                  <input name="username" value="{{ old('username') }}" type="text" class="form-control" placeholder="Enter Username">
                  @if ($errors->has('username'))
                    <small class="text-danger">{{ $errors->first('username') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input name="email" value="{{ old('email') }}" type="email" class="form-control" placeholder="Enter Email">
                  @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input name="password" value="{{ old('password') }}" type="password" class="form-control" placeholder="Enter Password">
                  @if ($errors->has('password'))
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>re-Password</label>
                  <input name="repassword" value="{{ old('repassword') }}" type="password" class="form-control" placeholder="Enter Password Again">
                  @if ($errors->has('repassword'))
                    <small class="text-danger">{{ $errors->first('repassword') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Level</label>
                  <select name="level" class="form-control">
                    <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Viewer</option>
                  </select>
                </div>

                <button class="btn btn-info" type="submit" name="btnSave" value="add">Add</button>
              </form>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
    
@endsection