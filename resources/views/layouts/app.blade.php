<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Scripts -->

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="#">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Site Title -->
		<title>{{ config('app.name') }}</title>

		<!-- Fav Icon -->
		<link rel="icon" href="img/favicon.png">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- NFTMax Stylesheet -->
		<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/font-awesome-all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/charts.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/slickslider.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
		<link rel="stylesheet" href="{{ asset('style.css') }}">
        <script src="{{asset('js/jquery.min.js')}}"></script>
		<script src="{{asset('js/jquery-migrate.js')}}"></script>
  		<link href="https://cdn.datatables.net/v/bs5/dt-2.2.1/datatables.min.css" rel="stylesheet">

</head>

<body>
	@include('layouts/RightSidebar')
    @include('layouts/Header')
	<section class="nftmax-adashboard nftmax-show">
<div class="container">
<div class="row">
<div class="col-lg-9 col-12 nftmax-main__column">
<div class="nftmax-body">
<div class="nftmax-dsinner">
<div class="nftmax-wallet__dashboard">
<div class="row">
<div class="col-12">
    @yield('content')
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
    @include('layouts/Footer')
     {{-- Bootstrap JS (make sure version matches your CSS) --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    {{-- jQuery (you already have this) --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    {{-- Render any inline scripts pushed from child views --}}
    @stack('scripts')
</body>

</html>
