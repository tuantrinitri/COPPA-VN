@extends('layout_common')

@section('site_title', 'Home')

@section('content')

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="{{ route('list-captain') }}">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-black-tie"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Observers</span>
                <span class="info-box-number">{{ $statistic_info['num_captain'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="{{ route('list-trip') }}">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-ship"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Trips</span>
                <span class="info-box-number">{{ $statistic_info['num_trip'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="{{ route('list-statistic') }}">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-upload"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Total Records</span>
                <span class="info-box-number">{{ $statistic_info['num_record'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="{{ route('list-family') }}">
            <div class="info-box">
              <span class="info-box-icon bg-green"><i class="fa fa-database"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Fishes / Families</span>
                <span class="info-box-number">{{ $statistic_info['num_fish'] }} / {{ $statistic_info['num_family'] }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </a>
          <!-- /.info-box -->
        </div>

      </div>
  
      <div class="row">
        <div class="col-sm-6">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <strong style="color: #3c8dbc">Observer</strong> - 

              <strong style="color: #00a65a">Trip</strong> - 

              <strong style="color: #f39c12">Record</strong>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="line-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-sm-6">
          
          <!-- MAP & BOX PANE -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Map</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="row">
                <div class="col-md-12">
                  <div class="pad">
                    <!-- Map will be created here -->
                    <div id="world-map-markers" style="height: 300px;"></div>
                  </div>
                </div>
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('libs/morris.js/morris.css') }}">
<link rel="stylesheet" href="{{ asset('libs/jvectormap/jquery-jvectormap.css') }}">
@endsection
@section('custom_js')

<script src="{{ asset('libs/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('libs/morris.js/morris.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script>
  $(document).ready(function () {
    "use strict";

    // LINE CHART
    var line = new Morris.Line({
      element: 'line-chart',
      resize: true,
      data: {!! json_encode($data_chart) !!},
      xkey: 'y',
      ykeys: ['captain', 'trip', 'record'],
      labels: ['Observer', 'Trip', 'Record'],
      lineColors: ['#3c8dbc', '#00a65a', '#f39c12'],
      hideHover: 'auto'
    });

    $('#world-map-markers').vectorMap({
      map              : 'world_mill_en',
      normalizeFunction: 'polynomial',
      hoverOpacity     : 0.7,
      hoverColor       : false,
      backgroundColor  : 'transparent',
      regionStyle      : {
        initial      : {
          fill            : 'rgba(210, 214, 222, 1)',
          'fill-opacity'  : 1,
          stroke          : 'none',
          'stroke-width'  : 0,
          'stroke-opacity': 1
        },
        hover        : {
          'fill-opacity': 0.7,
          cursor        : 'pointer'
        },
        selected     : {
          fill: 'yellow'
        },
        selectedHover: {}
      },
      markerStyle      : {
        initial: {
          fill  : '#00a65a',
          stroke: '#111'
        }
      },
      markers: {!! json_encode($data_map) !!}
    });
  });
</script>
@endsection