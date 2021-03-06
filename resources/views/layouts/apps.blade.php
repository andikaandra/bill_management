<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Data Billing Telkom Pekalongan</title>

  <link rel="stylesheet" href="{{asset('admin-template/vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin-template/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('admin-template/css/style.css')}}">
  <link rel="shortcut icon" href="{{asset('admin-template/images/favicon.png')}}"/>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
  <div class="container-scroller">
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('/')}}"><img src="{{asset('admin-template/images/logo.png')}}" alt="logo" style="width: 90px; height: auto;" /></a>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset('admin-template/images/logo-mini.svg')}}" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-logout"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Menu</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-logout"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">{{ __('Logout') }}</h6>
                  <p class="text-gray ellipsis mb-0">
                    
                  </p>
                </div>
              </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="{{url('/')}}" class="nav-link">
              <div class="nav-profile-image">
                <img src="{{asset('admin-template/images/user.png')}}" alt="profile">
                <span class="login-status online"></span>
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2">{{Auth::user()->name}}</span>
                <span class="text-secondary text-small">Admin</span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item" id="item-home">
            <a class="nav-link" href="{{url('/')}}">
              <span class="menu-title">DASHBOARD</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic4" aria-expanded="false" aria-controls="ui-basic4">
              <span class="menu-title">UPLOAD</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-upload menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic4">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" id="item-upload1" href="{{ url('upload/bill') }}">Bill</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-upload2" href="{{ url('upload/unbill') }}">Unbill</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-upload3" href="{{ url('upload/dosier') }}">Dosier</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-upload4" href="{{ url('upload/ukur-voice') }}">Voice</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-upload5" href="{{ url('upload/gpon') }}">GPON</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic5" aria-expanded="false" aria-controls="ui-basic5">
              <span class="menu-title">DOWNLOAD</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-download menu-icon"></i>
            </a>
            <div class="collapse" id="ui-basic5">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" id="item-download1" href="{{ url('download/bill') }}">Bill</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-download2" href="{{ url('download/unbill') }}">Unbill</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-download3" href="{{ url('download/dosier') }}">Dosier</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-download4" href="{{ url('download/ukur-voice') }}">Ukur Voice</a></li>
                <li class="nav-item"> <a class="nav-link" id="item-download5" href="{{ url('download/gpon') }}">GPON</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <a href="{{url('/')}}" style="text-decoration : none">
                <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi mdi-home"></i>                 
                </span>                
              </a>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>

        @yield('content')

        </div>


{{-- <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form> --}}

        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2019- {{date("Y")}} <a href="https://www.telkom.co.id" target="_blank">Telkom Pekalongan</a>. All rights reserved.</span>
          </div>
        </footer>
      </div>
    </div>
  </div>

  <script src="{{asset('admin-template/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('admin-template/vendors/js/vendor.bundle.addons.js')}}"></script>
  <script src="{{asset('admin-template/js/off-canvas.js')}}"></script>
  <script src="{{asset('admin-template/js/misc.js')}}"></script>
  <script src="{{asset('admin-template/js/dashboard.js')}}"></script>
  @yield('script')
</body>

</html>
