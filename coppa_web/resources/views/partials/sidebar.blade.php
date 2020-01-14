<!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> <span>Home</span></a></li>
        <li><a href="{{ route('list-captain') }}"><i class="fa fa-black-tie"></i> <span>List Observers</span></a></li>
        <li><a href="{{ route('list-trip') }}"><i class="fa fa-ship"></i> <span>List of Trips</span></a></li>
        <li><a href="{{ route('list-statistic') }}"><i class="fa fa-bar-chart"></i> <span>Statistics</span></a></li>
        <li><a href="{{ route('list-family') }}"><i class="fa fa-database"></i> <span>List Families & Fishes</span></a></li>
        @if (\Auth::user()->level == 1)
        <li><a href="{{ route('list-user') }}"><i class="fa fa-users"></i> <span>List accounts</span></a></li>
        @endif
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>