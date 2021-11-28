
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
</head>
<style>
  .login-page{
    background-image: url("/images/bg1.jpg") !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
  }
</style>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
   <img src="{{asset('/images/logo.png')}}" alt="" srcset="">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Let's ready for enjoy books</p>

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group mb-3">
        <input id="email" placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

    
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="input-group mb-3">
        <input id="password"  placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        </div>
        <div class="row" style="text-align:center">
          <div class="col-6">
            <div class="icheck-primary">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-6">
            @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
            @endif
          </div>
          <!-- /.col -->
        </div>
        <div class="social-auth-links text-center mb-3">
            <button type="submit" class="btn btn-block btn-primary">
                                        {{ __('Login') }}
            </button>
         
                         
        </div>
        <a href="{{url('/redirect')}}" class="btn btn-danger btn-block">
            Login with Google
        </a>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- REQUIRED SCRIPTS -->

<script src="{{asset('/js/app.js')}}"></script>
</body>
</html>

