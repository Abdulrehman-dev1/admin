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
    
    {{-- Mobile Sidebar Toggle Script - Ensure it works on all pages --}}
    <script>
    // Mobile Sidebar Toggle - Universal Handler
    (function() {
        function initSidebarToggle() {
            var toggleBtn = document.getElementById('mobile-sidebar-toggle');
            var overlay = document.querySelector('.nftmax-sidebar-overlay');
            
            function toggleSidebar() {
                var sidebar = document.querySelector('.nftmax-smenu');
                var header = document.querySelector('.nftmax-header');
                var dashboard = document.querySelector('.nftmax-adashboard');
                
                if (sidebar) sidebar.classList.toggle('nftmax-close');
                if (header) header.classList.toggle('nftmax-close');
                if (dashboard) dashboard.classList.toggle('nftmax-close');
                if (overlay) overlay.classList.toggle('active');
                console.log('Sidebar toggled');
            }
            
            function closeSidebar() {
                var sidebar = document.querySelector('.nftmax-smenu');
                var header = document.querySelector('.nftmax-header');
                var dashboard = document.querySelector('.nftmax-adashboard');
                
                if (sidebar) sidebar.classList.remove('nftmax-close');
                if (header) header.classList.remove('nftmax-close');
                if (dashboard) dashboard.classList.remove('nftmax-close');
                if (overlay) overlay.classList.remove('active');
            }
            
            // Button click handler
            if (toggleBtn) {
                // Remove any existing listeners
                var newBtn = toggleBtn.cloneNode(true);
                toggleBtn.parentNode.replaceChild(newBtn, toggleBtn);
                toggleBtn = newBtn;
                
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
            }
            
            // Overlay click handler
            if (overlay) {
                overlay.addEventListener('click', function(e) {
                    closeSidebar();
                });
            }
            
            // Also use jQuery if available
            if (typeof jQuery !== 'undefined') {
                jQuery(document).off('click', '.nftmax__sicon').on('click', '.nftmax__sicon', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleSidebar();
                });
                
                jQuery(document).off('click', '.nftmax-sidebar-overlay').on('click', '.nftmax-sidebar-overlay', function(e) {
                    closeSidebar();
                });
            }
        }
        
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSidebarToggle);
        } else {
            initSidebarToggle();
        }
        
        // Also try after a short delay to ensure everything is loaded
        setTimeout(initSidebarToggle, 100);
        setTimeout(initSidebarToggle, 500);
    })();
    </script>
</body>

</html>
