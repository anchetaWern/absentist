<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">

 
	<title>{{ $title }}</title>
</head>
<body>

  <div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">
          <img src="{{ asset('assets/img/logo.png') }}" id="logo" alt="logo">
          {{ Config::get('app.title') }}
        </a>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Register</a></li>
        </ul>
      </div>
    </div>
  </div>


  <div class="container">
   @yield('content')
  </div>

	<script src="{{ asset('assets/js/jquery.js') }}"></script>
	<script src="{{ asset('assets/lib/bootstrap/js/bootstrap.min.js') }}"></script>

  @if(!empty($handlebars))
  <script src="{{ asset('assets/js/handlebars.js') }}"></script>
  @endif

</body>
</html>
