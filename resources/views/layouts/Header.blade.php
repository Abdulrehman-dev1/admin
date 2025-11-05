<header class="nftmax-header">
    <div class="container">

        <div class="row g-50">
            <div class="col-12">
                <!-- Dashboard Header -->
                <div class="nftmax-header__inner">
                    <button type="button" class="nftmax__sicon close-icon d-xl-none" id="mobile-sidebar-toggle" style="cursor: pointer; background: none; border: none; padding: 0; z-index: 10000; position: relative;">
                        <img src="{{ asset('img/menu-toggle.svg') }}" alt="#">
                    </button>
                    <div class="nftmax-header__left">
                        <!-- Search Form -->
                        <!-- <div class="nftmax-header__form">
                            <form class="nftmax-header__form-inner" action="#">
                                <button class="search-btn" type="submit">
                                    <img src="{{ asset('img/search.png') }}" alt="#">
                                </button>
                                <input name="s" value="" type="text" placeholder="Search items, collections...">
                            </form>
                        </div> -->
                        <!-- End Search Form -->
                    </div>
                    <div class="nftmax-header__right">
                        <div class="nftmax-header__group">

                            <div class="nftmax-header__group-two">
                                <div class="nftmax-header__right">

                                    <div class="nftmax-header__author">
                                        <div class="nftmax-header__author-img">
                                            <img src="{{ asset('img/profile-pic.png') }}" alt="#">
                                        </div>

                                        <div class="nftmax-header__author-content">
                                            <h4 class="nftmax-header__author-title">{{Auth()->user()->name}}</h4>
                                            <p class="nftmax-header__author-text v1">
                                                {{Auth()->user()->nickname}}
                                            </p>
                                        </div>

                                        <!-- NFTMax Profile Hover -->
                                        <div class="nftmax-balance nftmax-profile__hover">
                                            <h3 class="nftmax-balance__title">My Profile</h3>
                                            <!-- NFTMax Balance List -->
                                            <ul class="nftmax-balance_list">
                                                <li>
                                                    <div class="nftmax-balance-info">
                                                        <div class="nftmax-balance__img nftmax-profile__img-one">
                                                            <img src="{{ asset('img/profile-1.png') }}" alt="#">
                                                        </div>
                                                        <h4 class="nftmax-balance-name">
                                                            <a href="users/1/edit">My Profile</a>
                                                        </h4>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="nftmax-balance-info">
                                                        <div class="nftmax-balance__img nftmax-profile__img-five">
                                                            <img src="{{ asset('img/profile-5.png') }}" alt="#">
                                                        </div>
                                                        <h4 class="nftmax-balance-name">
                                                            <a href="{{route('logout')}}">Log Out</a>
                                                        </h4>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- End NFTMax Balance Hover -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
