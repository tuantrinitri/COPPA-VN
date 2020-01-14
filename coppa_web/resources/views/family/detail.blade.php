@extends('layout_common')

@section('site_title', 'Fishes')

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
              <h3 class="box-title">List fishes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if ($listFish)
              <table class="table table-bordered table-hover">
                <tbody>
                  <tr>
                    <th style="width: 50px" class="text-center">ID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Image</th>
                  </tr>
                  @foreach ($listFish as $fish)
                  <tr>
                    <td class="text-center">{{ $fish['id'] }}</td>
                    <td class="text-center"><strong>{{ $fish['name'] }}</strong></td>
                    <td class="text-center"><img src="{{ asset('images/' . $fish['image']) }}" alt="{{ $fish['name'] }}" style="max-width: 300px"></td>
                  </tr>
                  @endforeach
                  
                </tbody>
              </table>
              @endif
              
            </div>
            <!-- /.box-body -->
          </div>

    </section>
    <!-- /.content -->
    
@endsection