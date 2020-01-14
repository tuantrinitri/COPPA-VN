@extends('layout_common')

@section('site_title', 'Record')

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
              <h3 class="box-title">Edit record</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="{{ route('post-edit-record', $record['id']) }}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $record['id'] }}">
                
                <div class="form-group">
                  <label>Long</label>
                  <input name="long" value="{{ old('long', $record['long']) }}" type="text" class="form-control" placeholder="Long">
                  @if ($errors->has('long'))
                    <small class="text-danger">{{ $errors->first('long') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Weight</label>
                  <input name="weight" value="{{ old('weight', $record['weight']) }}" type="text" class="form-control" placeholder="weight">
                  @if ($errors->has('weight'))
                    <small class="text-danger">{{ $errors->first('weight') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Lat</label>
                  <input name="lat" value="{{ old('lat', $record['lat']) }}" type="text" class="form-control" placeholder="lat">
                  @if ($errors->has('lat'))
                    <small class="text-danger">{{ $errors->first('lat') }}</small>
                  @endif
                </div>
                <div class="form-group">
                  <label>Lng</label>
                  <input name="lng" value="{{ old('lng', $record['lng']) }}" type="text" class="form-control" placeholder="lng">
                  @if ($errors->has('lng'))
                    <small class="text-danger">{{ $errors->first('lng') }}</small>
                  @endif
                </div>
                
                <button class="btn btn-info" type="submit" name="btnSave" value="edit">Save</button>
              </form>
            </div>
          </div>

    </section>
    <!-- /.content -->
    
@endsection