@extends('layout_common')

@section('site_title', 'Trips')

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
              <h3 class="box-title">List Trips</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('block_alert')
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th style="width: 50px" class="text-center">#</th>
                    <th class="text-center">From date</th>
                    <th class="text-center">To date</th>
                    <th class="text-center">Observer</th>
                    <th class="text-center">Num record</th>
                    <th></th>
                  </tr>
                  @foreach ($listTrip as $i => $trip)
                  <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $trip['from_date'] }}</td>
                    <td class="text-center">{{ $trip['to_date'] }}</td>
                    <td class="text-center">
                      <a href="{{ route('detail-captain', $trip['captain']['id']) }}">{{ urldecode($trip['captain']['fullname']) }}</a>
                    </td>
                    <td class="text-center">{{ $trip['num_record'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('detail-trip', $trip['id']) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                        @if (\Auth::user()->level == 1)
                        <a onclick="askDel(this);return false;" data-href="{{ route('delete-trip', $trip['id']) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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
        if (confirm('All data of trip will be delete. Do you want to delete this trip?')) {
          window.location.href = $(el).data('href');
        }
      }
    </script>
@endsection