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
      <div class="row">
        <div class="col-sm-4">
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username" style="margin-left: 0;">{{ urldecode($captain['fullname']) }}</h3>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Phone <span class="pull-right badge bg-blue">{{ $captain['phone'] }}</span></a></li>
                <li><a href="#">Vessel <span class="pull-right badge bg-aqua">{{ $captain['vessel'] }}</span></a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-ship"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Trips</span>
              <span class="info-box-number">{{ $captain_info['num_trip'] }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          @if (\Auth::user()->level == 1)
          <a href="{{ route('download-captain', $captain['id']) }}" class="btn btn-warning btn-sm"><i class="fa fa-download"></i> EXCEL</a>
          @endif
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-upload"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Records</span>
              <span class="info-box-number">{{ $captain_info['num_record'] }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

      </div>
      @if ($listTrip)
      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">List trips</h3>
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
                    <th class="text-center">Num record</th>
                    <th class="text-center"></th>
                  </tr>
                  @foreach ($listTrip as $i => $trip)
                  <tr>
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $trip['from_date'] }}</td>
                    <td class="text-center">{{ $trip['to_date'] }}</td>
                    <td class="text-center">{{ $trip['num_record'] }}</td>
                    <td class="text-center">
                        <a href="{{ route('detail-trip', $trip['id']) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
  
       @endif 
    </section>
    <!-- /.content -->
    
@endsection