
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BookCafe | Dashboard</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="/css/app.css">
  <script>
            window.trans = <?php
						// copy all translations from /resources/lang/CURRENT_LOCALE/* to global JS variable
						$lang_files = File::files(resource_path() . '/lang/' . App::getLocale());
						$trans = [];
						foreach ($lang_files as $f) {
							$filename = pathinfo($f)['filename'];
							$trans[$filename] = trans($filename);
						}
						echo json_encode($trans);
						?>;
    </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">{{ __('common.title')}}</a>
      </li>
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>  -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      @can('manage-administration')
        <request-noti></request-noti> <!--Vue Component -->
      @endcan
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa fa-globe" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="{{ route('locale', ['locale' => 'en']) }}" class="dropdown-item">
            @if(Auth::user()->lang == 'en')
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            @endif
            English
          </a>
          <a href="{{ route('locale', ['locale' => 'mm']) }}" class="dropdown-item">
            @if(Auth::user()->lang == 'mm')
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            @endif
            Myanmar
          </a>
          <!-- <a href="#" class="dropdown-item">
            @if(Auth::user()->lang == 'jp')
              <i class="fa fa-angle-double-right" aria-hidden="true"></i>
            @endif
            Japanese
          </a> -->
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

        <!-- <a href="#" class="brand-link">
        <img src="{{asset('images/spwm_logo.png')}}" alt="spwm Logo" class="brand-image"
            style="opacity: .8; ">
        </a> -->


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('images/male_user.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{Auth::user()->type != 'member' ? '/dashboard': '/my-dashboard'}}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @can('manage-administration')
            <admin-sidebar></admin-sidebar>
          @endcan
          @can('isMember')
            <member-sidebar></member-sidebar>
          @endcan
            <all-sidebar></all-sidebar>
          <li class="nav-item">
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="return logout(event);">
                    <i class="fas fa-sign-out-alt" style="margin-right:15px;"></i>
                    {{ __('common.logout')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content" style="margin-top: 10px;">
      <div class="container-fluid">
        <router-view></router-view>
        <vue-progress-bar></vue-progress-bar>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Book Cafe
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="http://thuhtettun.me" target="_blank">Thu Htet Tun</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<script src="{{asset('/js/app.js')}}"></script>
<script type="text/javascript">
    function logout(event){
            event.preventDefault();
            swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to logout',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    showCloseButton: true,
                    showLoaderOnConfirm: true
                    }).then((result) => {
                    if(result.value) {
                      document.getElementById('logout-form').submit();
                    }
                })
     }
</script>
</body>
</html>
