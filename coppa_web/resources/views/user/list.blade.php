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
              <h3 class="box-title">List users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('block_alert')
              <a href="{{ route('add-user') }}" class="btn btn-info" style="margin-bottom: 15px">Add user</a>
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th style="width: 50px" class="text-center">ID</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Level</th>
                    <th></th>
                  </tr>
                  @foreach ($listUser as $user)
                  <tr>
                    <td class="text-center">{{ $user['id'] }}</td>
                    <td class="text-center">{{ $user['username'] }}</td>
                    <td class="text-center">{{ $user['email'] }}</td>
                    <td class="text-center">{{ $user['level'] == 1 ? 'Admin' : 'Viewer' }}</td>
                    <td class="text-center">
                        <a href="{{ route('edit-user', $user['id']) }}" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                        <a href="javascript:;" data-href="{{ route('delete-user', $user['id']) }}" onclick="popupDelete(this); return false;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
<script>
  function popupDelete(el)
  {
    if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
      window.location.href = $(el).data('href');
    }
    return false;
  }
</script>  
@endsection