@extends('layout_common')

@section('site_title', 'Statistic')

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

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-upload"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Events</span>
          <span class="info-box-number">{{ $main_info['num_record'] }}</span>
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
      @if (\Auth::user()->level == 1)
      <div class="text-right">
        <a href="{{ route('download-statistic') }}" class="btn btn-warning"><i class="fa fa-download"></i> Excel</a>
      </div>
      @endif


    </div>
    <!-- /.box-header -->
    <div class="box-body">
      @include('block_alert')

      <table class="table table-bordered table-hover">
        <tbody>
          <tr>
            <th style="width: 50px" class="text-center">#</th>
            <th class="text-center">Observer</th>
            <th class="text-center">Trip</th>
            <th class="text-center">Species</th>
            <th class="text-center">Length (cm)</th>
            <th class="text-center">Weight (kg)</th>
            <th class="text-center">Location (latitude, longitude)</th>
            <th class="text-center">Catching time</th>
            <th class="text-center">Images</th>
            <th class="text-center" style="width: 70px"></th>
          </tr>
          <tr>
            <form metthò="get">
              <th><button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button></th>
              <th class="text-center">
                <select name="captain" class="form-control">
                  <option value="0">- All Observers -</option>
                  @foreach ($search_form['captain'] as $captain)
                  <option value="{{ $captain['id'] }}" {{ $captain['id'] == $search_form['captain_selected'] ? 'selected' : '' }}>{{ urldecode($captain['fullname']) }} ({{ $captain['phone'] }})</option>
                  @endforeach
                </select>
              </th>
              <th></th>
              <th class="text-center">
                <select name="fish" class="form-control">
                  <option value="0">- All Species -</option>
                  @foreach ($search_form['fish'] as $fish)
                  <option value="{{ $fish['id'] }}" {{ $fish['id'] == $search_form['fish_selected'] ? 'selected' : '' }}>{{ $fish['name'] }}</option>
                  @endforeach
                </select>
              </th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </form>
          </tr>

          @foreach ($listRecord as $i => $captain)
          @foreach ($captain['trips'] as $j => $trip)
          @foreach ($trip['records'] as $k => $record)
          <tr>

            @if ($j==0 && $k==0)
            <td class="text-center" rowspan="{{ $captain['num_rows'] }}">{{ $i+1 }}</td>
            <td class="text-center" rowspan="{{ $captain['num_rows'] }}"><a href="{{ route('detail-captain', $captain['id']) }}">{{ urldecode($captain['fullname']) }}</a></td>
            @endif

            @if ($k==0)
            <td class="text-center" rowspan="{{ count($captain['trips'][$j]['records']) }}">
              <strong>#{{ $j+1 }}</strong>
              <br><small>({{ $trip['from_date'] }} &rarr; {{ $trip['to_date'] }})</small>
            </td>
            @endif

            <td class="text-center">{{ ($record['fish']['name'] == '') ? 'Other families - Các loài khác' : $record['fish']['name'] }}</td>
            <td class="text-center">{{ $record['long'] }}</td>
            <td class="text-center">{{ $record['weight'] }}</td>
            <td class="text-center">{{ $record['lat'] }}, {{ $record['lng'] }} </td>
            <td class="text-center">{{ $record['catched_at'] }}</td>
            <td class="text-center">
              <a href="#" onclick="renderSlide(this); return false;" class="btn btn-xs btn-info" data-images="{{ $record['images'] }}" data-fishimg="{{ $record['fish']['image'] }}"><i class="fa fa-eye"></i></a>
            </td>
            <td class="text-center">
              @if (\Auth::user()->level == 1)
              <a href="{{ route('edit-record', $record['id']) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
              <a onclick="askDel(this);return false;" data-href="{{ route('delete-record', $record['id']) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
              @endif

            </td>
          </tr>
          @endforeach
          @endforeach
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
  function askDel(el)
  {
    if (confirm('Do you want to delete this record?')) {
      window.location.href = $(el).data('href');
    }
  }
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