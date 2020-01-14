@extends('layout_common')

@section('site_title', 'Observers')

@section('content')
<style>
  td {
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

  @if ($listRecord)
  <!-- Default box -->
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">Catch Events</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @include('block_alert')
      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <th style="width: 50px" class="text-center">#</th>
            <th class="text-center">Species</th>
            <th class="text-center">Length (cm)</th>
            <th class="text-center">Weight (kg)</th>
            <th class="text-center">Latitude</th>
            <th class="text-center">Longitude</th>
            <th class="text-center">Date/Time</th>
            <th class="text-center">Images</th>
          </tr>
          @foreach ($listRecord as $i => $record)
          <tr>
            <td class="text-center">{{ $i+1 }}</td>
            <td class="text-center">{{ $record['fish']['name'] }}</td>
            <td class="text-center">{{ $record['long'] }}</td>
            <td class="text-center">{{ $record['weight'] }}</td>
            <td class="text-center">{{ $record['lat'] }}</td>
            <td class="text-center">{{ $record['lng'] }}</td>
            <td class="text-center">{{ $record['catched_at'] }}</td>
            <td class="text-center">
              <a href="#" onclick="renderSlide(this); return false;" class="btn btn-xs btn-info" data-images="{{ $record['images'] }}" data-fishimg="{{ $record['fish']['image'] }}"><i class="fa fa-eye"></i></a>
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

<div class="modal fade" id="modal-slideshow">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div id="carousel-slideshow" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carousel-slideshow" data-slide-to="0" class=""></li>
            <li data-target="#carousel-slideshow" data-slide-to="1" class=""></li>
            <li data-target="#carousel-slideshow" data-slide-to="2" class="active"></li>
          </ol>

          <div class="carousel-inner">
            <div class="item">
              <img src="http://placehold.it/900x500/39CCCC/ffffff&amp;text=I+Love+Bootstrap" alt="First slide">

              <div class="carousel-caption">
                First Slide
              </div>
            </div>
            <div class="item">
              <img src="http://placehold.it/900x500/3c8dbc/ffffff&amp;text=I+Love+Bootstrap" alt="Second slide">

              <div class="carousel-caption">
                Second Slide
              </div>
            </div>
            <div class="item active">
              <img src="http://placehold.it/900x500/f39c12/ffffff&amp;text=I+Love+Bootstrap" alt="Third slide">

              <div class="carousel-caption">
                Third Slide
              </div>
            </div>
          </div>
          <a class="left carousel-control" href="#carousel-slideshow" data-slide="prev">
            <span class="fa fa-angle-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-slideshow" data-slide="next">
            <span class="fa fa-angle-right"></span>
          </a>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script>
  function renderSlide(el)
  {
    var arrImg = $(el).data('images');
    var html = html_dot = html_img = '';
    $('#carousel-slideshow').html('');
    if (Array.isArray(arrImg)) {
      console.log(arrImg);
      if (arrImg.length > 0) {
        html_dot = '<ol class="carousel-indicators">';
        html_img = '<div class="carousel-inner">';
        for (var i = 0; i < arrImg.length; i++) {
          if (i==0) {
            html_dot += '<li data-target="#carousel-slideshow" data-slide-to="' + i + '" class="active"></li>';
            
            html_img += '<div class="item active"><img src="'+base_url+'data_sync/'+arrImg[i]+'" style="margin:0 auto;"></div>';
          } else {
            html_dot += '<li data-target="#carousel-slideshow" data-slide-to="' + i + '" class=""></li>';
            
            html_img += '<div class="item"><img src="'+base_url+'data_sync/'+arrImg[i]+'" style="margin:0 auto;"></div>';
          }
        }

        html_dot += '</ol>';
        html_img += '</div>';
        
        html = html_img + '<a class="left carousel-control" href="#carousel-slideshow" data-slide="prev"><span class="fa fa-angle-left"></span></a><a class="right carousel-control" href="#carousel-slideshow" data-slide="next"><span class="fa fa-angle-right"></span></a>';
      } else {
        html = '<img src="'+base_url+'images/'+$(el).data('fishimg')+'" class="img-responsive">';
      }

    $('#carousel-slideshow').html(html);
    $('#modal-slideshow').modal('show'); 
    }
  }
</script>
@endsection