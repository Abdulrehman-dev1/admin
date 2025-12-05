<div class="body-bg" style="background-image:url('{{ asset('img/body-bg.jpg') }}')">
    <!-- Sidebar Overlay for Mobile -->
    <div class="nftmax-sidebar-overlay"></div>
    <!-- NFTMax Admin Menu -->
    <div class="nftmax-smenu">
        <!-- Admin Menu -->
        <div class="admin-menu">
            <!-- Logo -->
            <div class="logo">
                <a href="{{ route('dashboard') }}">
                    <img class="nftmax-logo__main" width="120" height="80" src="{{ asset('images/header-logo.png') }}" alt="#">
                </a>
            </div>
					<!-- Author Details -->
					<div class="admin-menu__one">

						<!-- Nav Menu -->
						<div class="menu-bar">
							<ul class="menu-bar__one" style="
    overflow-y: auto;
    height: 600px;
">

    <!-- Dashboard -->
    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            <span class="menu-bar__text">
                <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Dashboard</span>
            </span>
        </a>
    </li>

    <!-- Scraper -->
    <li class="{{ request()->routeIs('scraper.*') ? 'active' : '' }}">
        <a href="{{ route('scraper.index') }}">
            <span class="menu-bar__text">
                <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M1 2h14v2H1zM1 7h14v2H1zM1 12h14v2H1z"/>
                    </svg>
                </span>
                <span class="menu-bar__name">Property Scraper</span>
            </span>
        </a>
    </li>

    <!-- OLX Scraper -->
    <li class="{{ request()->routeIs('olx-scraper.*') ? 'active' : '' }}">
        <a href="{{ route('olx-scraper.index') }}">
            <span class="menu-bar__text">
                <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M1 2h14v2H1zM1 7h14v2H1zM1 12h14v2H1z"/>
                    </svg>
                </span>
                <span class="menu-bar__name">OLX Scraper</span>
            </span>
        </a>
    </li>

    <!-- Auctions -->
    <li class="{{ request()->routeIs('auctions.*') ? 'active' : '' }}">
        <a href="{{ route('auctions.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Auctions</span>
            </span>
        </a>
    </li>
    <li class="{{ request()->routeIs('auctionstatus.*') ? 'active' : '' }}">
  <a href="{{ route('auctionstatus.index') }}">
      <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Lot Verification</span>
            </span>
  </a>
</li>

    <!-- new -->

   <!-- Slider -->
<li class="{{ request()->routeIs('sliders.*') ? 'active' : '' }}">
    <a href="{{ route('sliders.index') }}">
        <span class="menu-bar__text">
            <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                <!-- Slider SVG Icon -->
                <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                    <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                    <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                    <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                </svg>
            </span>
            <span class="menu-bar__name">Slider</span>
        </span>
    </a>
</li>


    <!-- Auctions -->
    <li class="{{ request()->routeIs('auction_categories.*') ? 'active' : '' }}">
        <a href="{{ route('auction_categories.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Categories</span>
            </span>
        </a>
    </li>

    <!-- Auctions 
    <li class="{{ request()->routeIs('faq_questions.*') ? 'active' : '' }}">
        <a href="{{ route('faq_questions.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Faq Managment</span>
            </span>
        </a>
    </li>-->
    <!-- Auctions 
    <li class="{{ request()->routeIs('locations.*') ? 'active' : '' }}">
        <a href="{{ route('locations.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Location Master</span>
            </span>
        </a>
    </li>-->

    <!-- Auctions -->
   <!-- <li class="{{ request()->routeIs('content-pages.*') ? 'active' : '' }}">-->
   <!--     <a href="{{ route('content-pages.index') }}">-->
   <!--         <span class="menu-bar__text">-->
			<!--<span class="nftmax-menu-icon nftmax-svg-icon__v1">-->
                    <!-- Dashboard SVG Icon -->
   <!--                 <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">-->
   <!--                     <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>-->
   <!--                     <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>-->
   <!--                     <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>-->
   <!--                     <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>-->
   <!--                 </svg>-->
   <!--             </span>-->
   <!--             <span class="menu-bar__name">Pages</span>-->
   <!--         </span>-->
   <!--     </a>-->
   <!-- </li>-->
    <!-- Auctions 
    <li class="{{ request()->routeIs('testimonies.*') ? 'active' : '' }}">
        <a href="{{ route('testimonies.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Testimonials</span>
            </span>
        </a>
    </li>-->
    <!-- Auctions 
    <li class="{{ request()->routeIs('emailtemplates.*') ? 'active' : '' }}">
        <a href="{{ route('emailtemplates.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Email Templates</span>
            </span>
        </a>
    </li>-->
    <!-- Auctions
                              
    <li class="{{ request()->routeIs('identities.*') ? 'active' : '' }}">
        <a href="{{ route('identities.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Identity </span>
            </span>
        </a>
    </li> -->
       <li class="{{ request()->routeIs('individual-verifications.index') ? 'active' : '' }}">
    <a href="{{ route('individual-verifications.index') }}">
        <span class="menu-bar__text">
            <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                 <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
            </span>
            <span class="menu-bar__name">Individual Verify</span>
        </span>
    </a>
</li>
<li class="{{ request()->routeIs('corporate-verifications.*') ? 'active' : '' }}">
  <a href="{{ route('corporate-verifications.index') }}">
    <span class="menu-bar__text">
      <span class="nftmax-menu-icon nftmax-svg-icon__v1">
          <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
      </span>
      <span class="menu-bar__name">Corporate Verify</span>
    </span>
  </a>
</li>
<!--<div class="dropdown py-2">-->
<!--  <a-->
<!--    href="#"-->
<!--    class="dropdown-toggle d-flex align-items-center text-decoration-none"-->
<!--    id="lotVerifyDropdown"-->
<!--    data-bs-toggle="dropdown"-->
<!--    aria-expanded="false"-->
<!--  >-->
<!--    <span class="menu-bar__text">-->
<!--      <span class="nftmax-menu-icon nftmax-svg-icon__v1 ">-->
<!--        {{-- Your SVG icon --}}-->
<!--       <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">-->
<!--                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>-->
<!--                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>-->
<!--                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>-->
<!--                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>-->
<!--                    </svg>-->
<!--      </span>-->
<!--      <span class="menu-bar__name" style="color:#878F9A;     font-weight: 400; font-size:18px;">Lot Verification</span>-->
<!--    </span>-->
<!--  </a>-->
<!--<style>-->
<!--    .show{-->
<!--        position:relative !important;-->
<!--        transform: translate(0px, 0px) !important;-->
<!--        border:none;-->
<!--    }-->
<!--</style>-->
<!--  <ul class="dropdown-menu" aria-labelledby="lotVerifyDropdown" style="position:relative;">-->
<!--    <li class="{{ request()->routeIs('property-verifications.*') ? 'active' : '' }}">-->
<!--      <a class="dropdown-item" href="{{ route('property-verifications.index') }}">-->
<!--        <span class="menu-bar__text">-->
<!--          <span class="nftmax-menu-icon nftmax-svg-icon__v1 ">-->
<!--            {{-- SVG icon here --}}-->
<!--           <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">-->
<!--                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>-->
<!--                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>-->
<!--                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>-->
<!--                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>-->
<!--                    </svg>-->
<!--          </span>-->
<!--          <span class="menu-bar__name">Property Verify</span>-->
<!--        </span>-->
<!--      </a>-->
<!--    </li>-->
<!--    <li class="{{ request()->routeIs('vehicle-verifications.*') ? 'active' : '' }}">-->
<!--      <a class="dropdown-item" href="{{ route('vehicle-verifications.index') }}">-->
<!--        <span class="menu-bar__text">-->
<!--          <span class="nftmax-menu-icon nftmax-svg-icon__v1 ">-->
<!--            {{-- SVG icon here --}}-->
<!--           <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">-->
<!--                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>-->
<!--                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>-->
<!--                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>-->
<!--                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>-->
<!--                    </svg>-->
<!--          </span>-->
<!--          <span class="menu-bar__name">Vehicle Verify</span>-->
<!--        </span>-->
<!--      </a>-->
<!--    </li>-->
<!--  </ul>-->
<!--</div>-->

    <li class="">
  <a href="{{ route('payment-requests-admin') }}">
    <span class="menu-bar__text">
      <span class="nftmax-menu-icon nftmax-svg-icon__v1">
        <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
          <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"/>
          <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049Z"/>
          <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"/>
          <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"/>
        </svg>
      </span>
      <span class="menu-bar__name">Payment Request</span>
    </span>
  </a>
</li>

    <!-- Payment Verification -->
    <li class="{{ request()->routeIs('payment-verifications.*') ? 'active' : '' }}">
      <a href="{{ route('payment-verifications.index') }}">
        <span class="menu-bar__text">
          <span class="nftmax-menu-icon nftmax-svg-icon__v1">
            <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
              <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"/>
              <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049Z"/>
              <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"/>
              <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"/>
            </svg>
          </span>
          <span class="menu-bar__name">Payment Verification</span>
        </span>
      </a>
    </li>

    <!-- Orders -->
    <li class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
      <a href="{{ route('orders.index') }}">
        <span class="menu-bar__text">
          <span class="nftmax-menu-icon nftmax-svg-icon__v1">
            <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
              <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"/>
              <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049Z"/>
              <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"/>
              <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"/>
            </svg>
          </span>
          <span class="menu-bar__name">Orders</span>
        </span>
      </a>
    </li>

    <!-- Auctions -->
    {{-- <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Reports</span>
            </span>
        </a>
    </li> --}}
    <!-- Auctions -->
    {{-- <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Notification</span>
            </span>
        </a>
    </li> --}}
    <!-- Auctions -->
    {{-- <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">SMS</span>
            </span>
        </a>
    </li> --}}
    <!-- Auctions -->
     <li class="{{ request()->routeIs('blogs.*') ? 'active' : '' }}">
    <a href="{{ route('blogs.index') }}">
        <span class="menu-bar__text">
            <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                <!-- Dashboard SVG Icon -->
                <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                    <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                    <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                    <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                </svg>
            </span>
            <span class="menu-bar__name">Blogs</span>
        </span>
    </a>
</li>
    <li class="{{ request()->routeIs('referrals.*') ? 'active' : '' }}">
    <a href="{{ route('referrals.index') }}">
        <span class="menu-bar__text">
            <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                <!-- Dashboard SVG Icon -->
                <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                    <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                    <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                    <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                </svg>
            </span>
            <span class="menu-bar__name">Referrals</span>
        </span>
    </a>
</li>

    <!-- Buy Now Inquire -->
    <li class="{{ request()->routeIs('buy-now-inquiries.*') ? 'active' : '' }}">
        <a href="{{ route('buy-now-inquiries.index') }}">
            <span class="menu-bar__text">
                <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Buy Now Inquire</span>
            </span>
        </a>
    </li>

     <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">User Management</span>
            </span>
        </a>
    </li> 
     <li class="{{ request()->routeIs('seo.*') ? 'active' : '' }}">
        <a href="{{ route('seo.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Seo Management</span>
            </span>
        </a>
    </li> 
	<li class="{{ request()->routeIs('wallets.*') ? 'active' : '' }}">
        <a href="{{ route('wallets.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Wallets</span>
            </span>
        </a>
    </li> 



    <!-- Auctions -->
    <li class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
        <a href="{{ route('transactions.index') }}">
            <span class="menu-bar__text">
			<span class="nftmax-menu-icon nftmax-svg-icon__v1">
                    <!-- Dashboard SVG Icon -->
                    <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
                </span>
                <span class="menu-bar__name">Payments</span>
            </span>
        </a>
    </li>
  <li class="{{ request()->routeIs('promotions.*') ? 'active' : '' }}">
    <a href="{{ route('promotions.index') }}">
        <span class="menu-bar__text">
            <span class="nftmax-menu-icon nftmax-svg-icon__v1">
                <!-- Promotion / Flash Icon -->
                 <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>
                        <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>
                        <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>
                        <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>
                    </svg>
            </span>
            <span class="menu-bar__name">Promotions</span>
        </span>
    </a>
</li>

    <!-- Auctions -->
   <!-- <li class="">-->
   <!--     <a href="{{ url('/logout') }}">-->
   <!--         <span class="menu-bar__text">-->
			<!--<span class="nftmax-menu-icon nftmax-svg-icon__v1">-->
                    <!-- Dashboard SVG Icon -->
   <!--                 <svg class="nftmax-svg-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">-->
   <!--                     <path d="M0.800781 2.60005V7.40005H7.40078V0.800049H2.60078C2.12339 0.800049 1.66555 0.989691 1.32799 1.32726C0.990424 1.66482 0.800781 2.12266 0.800781 2.60005H0.800781Z"></path>-->
   <!--                     <path d="M13.4016 0.800049H8.60156V7.40005H15.2016V2.60005C15.2016 2.12266 15.0119 1.66482 14.6744 1.32726C14.3368 0.989691 13.879 0.800049 13.4016 0.800049V0.800049Z"></path>-->
   <!--                     <path d="M0.800781 13.4001C0.800781 13.8775 0.990424 14.3353 1.32799 14.6729C1.66555 15.0105 2.12339 15.2001 2.60078 15.2001H7.40078V8.6001H0.800781V13.4001Z"></path>-->
   <!--                     <path d="M8.60156 15.2001H13.4016C13.879 15.2001 14.3368 15.0105 14.6744 14.6729C15.0119 14.3353 15.2016 13.8775 15.2016 13.4001V8.6001H8.60156V15.2001Z"></path>-->
   <!--                 </svg>-->
   <!--             </span>-->
   <!--             <span class="menu-bar__name">Logout</span>-->
   <!--         </span>-->
   <!--     </a>-->
   <!-- </li>-->
</ul>

						</div>
						<!-- End Nav Menu -->
					</div>

					<div class="admin-menu__two mg-top-50">
						<h4 class="admin-menu__title nftmax-scolor">Settings</h4>
						<!-- Nav Menu -->
						<div class="menu-bar">
							<ul class="menu-bar__one">

                                
								<li><a href="users/1/edit"><span class="menu-bar__text"><span class="nftmax-menu-icon nftmax-svg-icon__v10"><svg class="nftmax-svg-icon"  viewBox="0 0 15 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.8692 11.6667H4.13085C3.03569 11.668 1.98576 12.1036 1.21136 12.878C0.436961 13.6524 0.00132319 14.7023 0 15.7975V20H15.0001V15.7975C14.9987 14.7023 14.5631 13.6524 13.7887 12.878C13.0143 12.1036 11.9644 11.668 10.8692 11.6667Z"></path><path d="M7.49953 10C10.261 10 12.4995 7.76145 12.4995 5.00002C12.4995 2.23858 10.261 0 7.49953 0C4.7381 0 2.49951 2.23858 2.49951 5.00002C2.49951 7.76145 4.7381 10 7.49953 10Z"></path></svg></span><span class="menu-bar__name">My Profile</span> </span></a></li>
							

                            </ul>
						</div>
						<!-- End Nav Menu -->
					</div>

					<div class="logout-button mb-5">
                <a class="nftmax-btn primary" href="#" data-bs-toggle="modal" data-bs-target="#logout_modal">
                    <div class="logo-button__icon">
                        <img src="{{ asset('img/logout.png') }}" alt="#">
                    </div>
                    <span class="menu-bar__name">Signout</span>
                </a>
            </div>
        </div>
        <!-- End Admin Menu -->
    </div>
    <!-- End NFTMax Admin Menu -->

    <!-- Logout Modal -->
    <div class="nftmax-preview__modal modal fade" id="logout_modal" tabindex="-1" aria-labelledby="logoutmodal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered nftmax-close__modal-close">
            <div class="modal-content nftmax-preview__modal-content">
                <div class="modal-header nftmax__modal__header">
                    <h4 class="modal-title nftmax-preview__modal-title" id="logoutmodal">Confirm</h4>
                    <button type="button" class="nftmax-preview__modal--close btn-close" data-bs-dismiss="modal" aria-label="Close"><svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M36 16.16C36 17.4399 36 18.7199 36 20.0001C35.7911 20.0709 35.8636 20.2554 35.8385 20.4001C34.5321 27.9453 30.246 32.9248 22.9603 35.2822C21.9006 35.6251 20.7753 35.7657 19.6802 35.9997C18.4003 35.9997 17.1204 35.9997 15.8401 35.9997C15.5896 35.7086 15.2189 35.7732 14.9034 35.7093C7.77231 34.2621 3.08728 30.0725 0.769671 23.187C0.435002 22.1926 0.445997 21.1199 0 20.1599C0 18.7198 0 17.2798 0 15.8398C0.291376 15.6195 0.214408 15.2656 0.270759 14.9808C1.71321 7.69774 6.02611 2.99691 13.0428 0.700951C14.0118 0.383805 15.0509 0.386897 15.9999 0C17.2265 0 18.4532 0 19.6799 0C19.7156 0.124041 19.8125 0.136067 19.9225 0.146719C27.3 0.868973 33.5322 6.21922 35.3801 13.427C35.6121 14.3313 35.7945 15.2484 36 16.16ZM33.011 18.0787C33.0433 9.77105 26.3423 3.00309 18.077 2.9945C9.78479 2.98626 3.00344 9.658 2.98523 17.8426C2.96667 26.1633 9.58859 32.9601 17.7602 33.0079C26.197 33.0577 32.9787 26.4186 33.011 18.0787Z" fill="#374557" fill-opacity="0.6"></path><path d="M15.9309 18.023C13.9329 16.037 12.007 14.1207 10.0787 12.2072C9.60071 11.733 9.26398 11.2162 9.51996 10.506C9.945 9.32677 11.1954 9.0811 12.1437 10.0174C13.9067 11.7585 15.6766 13.494 17.385 15.2879C17.9108 15.8401 18.1633 15.7487 18.6375 15.258C20.3586 13.4761 22.1199 11.7327 23.8822 9.99096C24.8175 9.06632 26.1095 9.33639 26.4967 10.517C26.7286 11.2241 26.3919 11.7413 25.9133 12.2178C24.1757 13.9472 22.4477 15.6855 20.7104 17.4148C20.5228 17.6018 20.2964 17.7495 20.0466 17.9485C22.0831 19.974 24.0372 21.8992 25.9689 23.8468C26.9262 24.8119 26.6489 26.1101 25.4336 26.4987C24.712 26.7292 24.2131 26.3441 23.7455 25.8757C21.9945 24.1227 20.2232 22.3892 18.5045 20.6049C18.0698 20.1534 17.8716 20.2269 17.4802 20.6282C15.732 22.4215 13.9493 24.1807 12.1777 25.951C11.7022 26.4262 11.193 26.7471 10.4738 26.4537C9.31345 25.9798 9.06881 24.8398 9.98589 23.8952C11.285 22.5576 12.6138 21.2484 13.9387 19.9355C14.5792 19.3005 15.2399 18.6852 15.9309 18.023Z" fill="#374557" fill-opacity="0.6"></path></svg></button>

                </div>
                <div class="modal-body nftmax-modal__body modal-body nftmax-close__body">
                    <div class="nftmax-preview__close">
                        <div class="nftmax-preview__close-img">
                            <img src="{{ asset('img/close.png') }}" alt="#">
                        </div>
                        <h2 class="nftmax-preview__close-title">Are you sure you want to Logout </h2>
                        <div class="nftmax__item-button--group">
                            <button class="nftmax__item-button--single nftmax-btn nftmax-btn__bordered bg radius" type="button"><a href="{{ url('/logout') }}">Yes Logout</a></button>
                            <button class="nftmax__item-button--single nftmax-btn nftmax-btn__bordered--plus radius" data-bs-dismiss="modal"><span class="ntfmax__btn-textgr">Not Now</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Logout Modal -->

    <!-- Connect to Wallet -->

    <!-- End Connect to Wallet -->
</div>
