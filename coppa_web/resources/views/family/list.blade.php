@extends('layout_common')

@section('site_title', 'Families')

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
              <h3 class="box-title">List families</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th style="width: 50px" class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Image</th>
                  </tr>
                  @foreach ($listFamily as $family)
                  <tr>
                    <td class="text-center">{{ $family['id'] }}</td>
                    <td class="text-center"><a href="{{ route('detail-family', $family['id']) }}"><strong>{{ $family['name'] }}</strong></a></td>
                    <td class="text-center"><img src="{{ asset('images/' . $family['image']) }}" alt="{{ $family['name'] }}"></td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
    
@endsection