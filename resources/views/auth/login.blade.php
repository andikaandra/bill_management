<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Telkom Pekalongan - management</title>
    <link rel="stylesheet" href="{{ asset('admin-template/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-template/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('admin-template/images/favicon.png') }}" />
</head>

<body>
    <div id="app">
        <main>
          <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
              <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                  <div class="col-lg-4 col-12 col-md-6 mx-auto">
                    <div class="auth-form-light text-left p-5">
                      <div class="brand-logo" align="center">
                        <img src="{{ asset('admin-template/images/logo.png') }}">
                      </div>
                      <h4>Data Management - Login</h4>
                      <h6 class="font-weight-light">Sign in to continue.</h6>
                      <form class="pt-3" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                          <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-lg" name="email" value="{{ old('email') }}" required autofocus placeholder="email">
                          @if ($errors->has('email'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif                  
                        </div>
                        <div class="form-group">
                          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-lg" name="password" required placeholder="password">

                          @if ($errors->has('password'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                        </div>
                        <div class="mt-3">
                          <button class="btn btn-block btn-gradient-danger btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                        </div>
                        <div class="text-center mt-4 font-weight-light">
                          Don't have an account? <a href="{{url('register')}}" class="text-danger">Create</a>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
    </div>
  <script src="{{ asset('admin-template/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('admin-template/vendors/js/vendor.bundle.addons.js') }}"></script>
  <script src="{{ asset('admin-template/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin-template/js/misc.js') }}"></script>
</body>

</html>
