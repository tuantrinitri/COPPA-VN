@extends('layout_common')

@section('site_title', 'Observers')

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
              <h3 class="box-title">List Observers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('block_alert')
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th style="width: 50px" class="text-center">#</th>
                    <th class="text-center">Fullname</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Vessel</th>
                    <th></th>
                  </tr>
                  @foreach ($listCaptain as $i => $captain)
                  <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ urldecode($captain['fullname']) }}</td>
                    <td class="text-center">{{ $captain['phone'] }}</td>
                    <td class="text-center">{{ $captain['vessel'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('detail-captain', $captain['id']) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                        @if (\Auth::user()->level == 1)
                          <a onclick="askDel(this);return false;" data-href="{{ route('delete-captain', $captain['id']) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                          @endif
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
      function askDel(el)
      {
        if (confirm('All data of observer (trips, records) will be delete. Do you want to delete this observer?')) {
          window.location.href = $(el).data('href');
        }
      }
    </script>
@endsection