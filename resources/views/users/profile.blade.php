@extends('layouts.app')

@section('content')
<section class="nftmax-adashboards nftmax-show">

    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-12 nftmax-main__column">
                <div class="nftmax-body">
                    <!-- Dashboard Inner -->
                    <div class="nftmax-dsinner">

                        <!-- NFTMax User Profile -->
                        <div class="nftmax-userprofile mg-top-40">
                            <div class="nftmax-userprofile__header">
                                <img src="img/profile-cover.png" alt="#">
                            </div>
                            <div class="nftmax-userprofile__user">
                                <div class="nftmax-userprofile__content">
                                    <div class="nftmax-userprofile__thumb">
                                        <img src="img/profile-thumb.png" alt="#">
                                    </div>
                                    <div class="nftmax-userprofile__info">
                                        <h4 class="nftmax-userprofile__info-title">{{ $user->name }}</h4>
                                        <p class="nftmax-userprofile__info-text"></p>

                                    </div>
                                </div>
                                <div class="nftmax-userprofile__right">
                                    <a href="#" class="nftmax-btn nftmax-btn__primary nftmax-btn__profile radius">Edit Profile</a>

                                </div>
                            </div>
                        </div>

                        <div class="nftmax-pcats">

                            <!-- Profile Menu -->
                            <div class="nftmax-pcats__bar">
                                <div class="nftmax-pcats__list list-group " id="list-tab" role="tablist">
                                    <a class="list-group-item active" data-bs-toggle="list" href="#tab_1" role="tab" href="profile.html">Paid Invoices<span class="nftmax-pcats__count">16</span></a>
                                    <a class="list-group-item" data-bs-toggle="list" href="#tab_2" role="tab">Pending Invoices<span class="nftmax-pcats__count">09</span></a>
                                    <a class="list-group-item" data-bs-toggle="list" href="#tab_3" role="tab">Hold Invoices<span class="nftmax-pcats__count">35</span></a>
                                    <a class="list-group-item" data-bs-toggle="list" href="#tab_4" role="tab">Cancel Shippment<span class="nftmax-pcats__count">14</span></a>
                                    <a class="list-group-item" data-bs-toggle="list" href="#tab_5" role="tab">Dispute<span class="nftmax-pcats__count">21</span></a>

                                </div>

                            </div>
                            <!-- End Profile Menu -->


                            <div class="tab-content" id="nav-tabContent">
                                <!-- Single Tab -->
                                <div class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="nav-home-tab">



                                    <div class="row nftmax-gap-sq30">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
                                                <!-- NFTMax Table Head -->
                                                <thead class="nftmax-table__head">
                                                    <tr>
                                                        <th class="nftmax-table__column-1 nftmax-table__h1">ID</th>
                                                        <th class="nftmax-table__column-2 nftmax-table__h2">User ID</th>
                                                        <th class="nftmax-table__column-3 nftmax-table__h3">Cargo Type</th>
                                                        <th class="nftmax-table__column-4 nftmax-table__h4">Origin</th>
                                                        <th class="nftmax-table__column-5 nftmax-table__h5">Destination</th>
                                                        <th class="nftmax-table__column-6 nftmax-table__h6">Actions</th>
                                                    </tr>
                                                </thead>
                                                <!-- NFTMax Table Body -->
                                                <tbody class="nftmax-table__body">

                                                    <tr>
                                                        <td colspan="6" class="nftmax-table__no-data">No bookings found.</td>
                                                    </tr>



                                                </tbody>
                                                <!-- End NFTMax Table Body -->
                                            </table>
                                            <!-- End Marketplace Item -->
                                        </div>

                                    </div>
                                </div>

                                {{-- <div class="tab-pane fade" id="tab_2" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="nftmax-pptabs mg-btm-20">
                                                <div class="nftmax-pptabs__form">
                                                    <form class="nftmax-header__form-inner nftmax-header__form-profile" action="#">
                                                        <button class="search-btn" type="submit"><img src="img/search.png" alt="#"></button>
                                                        <input name="s" value="" type="text" placeholder="Search items, collections...">
                                                    </form>
                                                </div>
                                                <div class="nftmax-pptabs__main">
                                                    <ul  class="nav nav-tabs nftmax-dropdown__list" id="nav-tab" role="tablist">
                                                        <li class="nav-item dropdown">
                                                            <a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle">Recently Received <span><svg width="20" height="10" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.7" d="M12.4124 0.247421C12.3327 0.169022 12.2379 0.106794 12.1335 0.0643287C12.0291 0.0218632 11.917 0 11.8039 0C11.6908 0 11.5787 0.0218632 11.4743 0.0643287C11.3699 0.106794 11.2751 0.169022 11.1954 0.247421L7.27012 4.07837C7.19045 4.15677 7.09566 4.219 6.99122 4.26146C6.88678 4.30393 6.77476 4.32579 6.66162 4.32579C6.54848 4.32579 6.43646 4.30393 6.33202 4.26146C6.22758 4.219 6.13279 4.15677 6.05312 4.07837L2.12785 0.247421C2.04818 0.169022 1.95338 0.106794 1.84895 0.0643287C1.74451 0.0218632 1.63249 0 1.51935 0C1.40621 0 1.29419 0.0218632 1.18975 0.0643287C1.08531 0.106794 0.990517 0.169022 0.910844 0.247421C0.751218 0.404141 0.661621 0.616141 0.661621 0.837119C0.661621 1.0581 0.751218 1.2701 0.910844 1.42682L4.84468 5.26613C5.32677 5.73605 5.98027 6 6.66162 6C7.34297 6 7.99647 5.73605 8.47856 5.26613L12.4124 1.42682C12.572 1.2701 12.6616 1.0581 12.6616 0.837119C12.6616 0.616141 12.572 0.404141 12.4124 0.247421Z" fill="#374557" fill-opacity="0.6"></path></svg></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row nftmax-gap-sq30 trending-action__actives">
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-1.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-2.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="#">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-3.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-4.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-1.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-2.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-3.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-4.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Atwork</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_3" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="nftmax-pptabs mg-btm-20">
                                                <div class="nftmax-pptabs__form">
                                                    <form class="nftmax-header__form-inner nftmax-header__form-profile" action="#">
                                                        <button class="search-btn" type="submit"><img src="img/search.png" alt="#"></button>
                                                        <input name="s" value="" type="text" placeholder="Search items, collections...">
                                                    </form>
                                                </div>
                                                <div class="nftmax-pptabs__main">
                                                    <ul  class="nav nav-tabs nftmax-dropdown__list" id="nav-tab" role="tablist">
                                                        <li class="nav-item dropdown">
                                                            <a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle">Recently Received <span><svg width="20" height="10" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.7" d="M12.4124 0.247421C12.3327 0.169022 12.2379 0.106794 12.1335 0.0643287C12.0291 0.0218632 11.917 0 11.8039 0C11.6908 0 11.5787 0.0218632 11.4743 0.0643287C11.3699 0.106794 11.2751 0.169022 11.1954 0.247421L7.27012 4.07837C7.19045 4.15677 7.09566 4.219 6.99122 4.26146C6.88678 4.30393 6.77476 4.32579 6.66162 4.32579C6.54848 4.32579 6.43646 4.30393 6.33202 4.26146C6.22758 4.219 6.13279 4.15677 6.05312 4.07837L2.12785 0.247421C2.04818 0.169022 1.95338 0.106794 1.84895 0.0643287C1.74451 0.0218632 1.63249 0 1.51935 0C1.40621 0 1.29419 0.0218632 1.18975 0.0643287C1.08531 0.106794 0.990517 0.169022 0.910844 0.247421C0.751218 0.404141 0.661621 0.616141 0.661621 0.837119C0.661621 1.0581 0.751218 1.2701 0.910844 1.42682L4.84468 5.26613C5.32677 5.73605 5.98027 6 6.66162 6C7.34297 6 7.99647 5.73605 8.47856 5.26613L12.4124 1.42682C12.572 1.2701 12.6616 1.0581 12.6616 0.837119C12.6616 0.616141 12.572 0.404141 12.4124 0.247421Z" fill="#374557" fill-opacity="0.6"></path></svg></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nftmax-inner__heading nftmax-pp__title mt-0">
                                        <h2 class="nftmax-inner__page-title">Create for Sell</h2>
                                    </div>
                                    <div class="row nftmax-gap-sq30 trending-action__actives">
                                        <!-- End Marketplace Item -->
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-1.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="marketplace-details.html">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-2.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="marketplace-details.html">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-3.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="marketplace-details.html">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                    </div>

                                    <div class="nftmax-inner__heading nftmax-pp__title">
                                        <h2 class="nftmax-inner__page-title">Create for Bits</h2>
                                    </div>

                                    <div class="row nftmax-gap-sq30  trending-action__actives">
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-1.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="#">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-2.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-3.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-4.png" alt="#">
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_4" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="nftmax-pptabs mg-btm-20">
                                                <div class="nftmax-pptabs__form">
                                                    <form class="nftmax-header__form-inner nftmax-header__form-profile" action="#">
                                                        <button class="search-btn" type="submit"><img src="img/search.png" alt="#"></button>
                                                        <input name="s" value="" type="text" placeholder="Search items, collections...">
                                                    </form>
                                                </div>
                                                <div class="nftmax-pptabs__main">
                                                    <ul  class="nav nav-tabs nftmax-dropdown__list" id="nav-tab" role="tablist">
                                                        <li class="nav-item dropdown">
                                                            <a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle">Recently Received <span><svg width="20" height="10" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.7" d="M12.4124 0.247421C12.3327 0.169022 12.2379 0.106794 12.1335 0.0643287C12.0291 0.0218632 11.917 0 11.8039 0C11.6908 0 11.5787 0.0218632 11.4743 0.0643287C11.3699 0.106794 11.2751 0.169022 11.1954 0.247421L7.27012 4.07837C7.19045 4.15677 7.09566 4.219 6.99122 4.26146C6.88678 4.30393 6.77476 4.32579 6.66162 4.32579C6.54848 4.32579 6.43646 4.30393 6.33202 4.26146C6.22758 4.219 6.13279 4.15677 6.05312 4.07837L2.12785 0.247421C2.04818 0.169022 1.95338 0.106794 1.84895 0.0643287C1.74451 0.0218632 1.63249 0 1.51935 0C1.40621 0 1.29419 0.0218632 1.18975 0.0643287C1.08531 0.106794 0.990517 0.169022 0.910844 0.247421C0.751218 0.404141 0.661621 0.616141 0.661621 0.837119C0.661621 1.0581 0.751218 1.2701 0.910844 1.42682L4.84468 5.26613C5.32677 5.73605 5.98027 6 6.66162 6C7.34297 6 7.99647 5.73605 8.47856 5.26613L12.4124 1.42682C12.572 1.2701 12.6616 1.0581 12.6616 0.837119C12.6616 0.616141 12.572 0.404141 12.4124 0.247421Z" fill="#374557" fill-opacity="0.6"></path></svg></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="nftmax-inner__heading nftmax-pp__title mt-0">
                                        <h2 class="nftmax-inner__page-title">Create for Sell</h2>
                                    </div>
                                    <div class="row nftmax-gap-sq30 trending-action__actives">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-1.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-2.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <!-- Marketplace Single Item -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <div class="nftmax-trendmeta">
                                                    <div class="nftmax-trendmeta__main">
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Owned by</span>
                                                                <h4 class="nftmax-trendmeta__title">Rrayak John</h4>
                                                            </div>
                                                        </div>
                                                        <div class="nftmax-trendmeta__author">
                                                            <div class="nftmax-trendmeta__content">
                                                                <span class="nftmax-trendmeta__small">Create by</span>
                                                                <h4 class="nftmax-trendmeta__title">Yuaisn Kha</h4>
                                                            </div>
                                                            <div class="nftmax-trendmeta__img">
                                                                <img src="img/market-author-2.png" alt="#">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__badge"><span>Active</span></div>
                                                    <div class="trending-action__button v2">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/marketplace-3.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body trending-marketplace__body">
                                                    <h2 class="trending-action__title"><a href="#">Interconnected Planes</a></h2>
                                                    <div class="nftmax-currency">
                                                        <div class="nftmax-currency__main">
                                                            <div class="nftmax-currency__icon"><img src="img/eth-icon.png" alt="#"></div>
                                                            <div class="nftmax-currency__content">
                                                                <h4 class="nftmax-currency__content-title">75,320 ETH </h4>
                                                                <p class="nftmax-currency__content-sub">(773.69  USD)</p>
                                                            </div>
                                                        </div>
                                                        <a href="#" class="nftmax-btn nftmax-btn__secondary radius">On Sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Marketplace Item -->
                                        </div>
                                    </div>

                                    <div class="nftmax-inner__heading nftmax-pp__title">
                                        <h2 class="nftmax-inner__page-title">Create for Bits</h2>
                                    </div>

                                    <div class="row nftmax-gap-30 trending-action__actives">
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-1.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-2.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-3.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                        <div class="col-xxl-3 col-lg-3 col-md-6 col-12">
                                            <!-- Treadning Single -->
                                            <div class="trending-action__single nftmax-pd-20">
                                                <!-- Trending Head -->
                                                <div class="trending-action__head">
                                                    <div class="trending-action__button">
                                                        <a class="trending-action__btn heart-icon"><i class="fa-solid fa-heart"></i></a>
                                                        <a class="trending-action__btn"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                    </div>
                                                    <img src="img/trending-img-4.png" alt="#">
                                                    <div class="trending-action__remove"><i class="fa-solid fa-eye-slash"></i></div>
                                                </div>
                                                <!-- Trending Body -->
                                                <div class="trending-action__body">
                                                    <div class="trending-action__author-meta">
                                                        <div class="trending-action__author-img"><img src="img/author-pic.png" alt="#"></div>
                                                        <p class="trending-action__author-name">Owned by <a href="profile.html">Bilout</a></p>
                                                    </div>
                                                    <h2 class="trending-action__title"><a href="active-bids.html">Interconnected Planes</a></h2>
                                                    <div class="dashboard-banner__bid dashboard-banner__bid-v2">
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Current Bid</p>
                                                            <h3 class="dashboard-banner__group-title">75,320 ETH</h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                        <div class="dashboard-banner__middle-border"></div>
                                                        <!-- Single Bid -->
                                                        <div class="dashboard-banner__group dashboard-banner__group-v2">
                                                            <p class="dashboard-banner__group-small">Remaing Time</p>
                                                            <h3 class="dashboard-banner__group-title" id="CountDown" data-countdown="2023/09/01"></h3>
                                                        </div>
                                                        <!-- End Single Bid -->
                                                    </div>
                                                </div>
                                                <div class="dashboard-banner__button trending-action__bottom">
                                                    <a href="active-bids.html" class="nftmax-btn nftmax-btn__secondary radius">Place a Bid</a>
                                                    <a href="marketplace.html" class="nftmax-btn trs-white">View Art Work</a>
                                                </div>
                                            </div>
                                            <!-- End Treadning Single -->
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_5" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="nftmax-pptabs mg-btm-20">
                                                <div class="nftmax-pptabs__form">
                                                    <form class="nftmax-header__form-inner nftmax-header__form-profile" action="#">
                                                        <button class="search-btn" type="submit"><img src="img/search.png" alt="#"></button>
                                                        <input name="s" value="" type="text" placeholder="Search items, collections...">
                                                    </form>
                                                </div>
                                                <div class="nftmax-pptabs__main">
                                                    <ul  class="nav nav-tabs nftmax-dropdown__list" id="nav-tab" role="tablist">
                                                        <li class="nav-item dropdown">
                                                            <a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle">Recently Received <span><svg width="20" height="10" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.7" d="M12.4124 0.247421C12.3327 0.169022 12.2379 0.106794 12.1335 0.0643287C12.0291 0.0218632 11.917 0 11.8039 0C11.6908 0 11.5787 0.0218632 11.4743 0.0643287C11.3699 0.106794 11.2751 0.169022 11.1954 0.247421L7.27012 4.07837C7.19045 4.15677 7.09566 4.219 6.99122 4.26146C6.88678 4.30393 6.77476 4.32579 6.66162 4.32579C6.54848 4.32579 6.43646 4.30393 6.33202 4.26146C6.22758 4.219 6.13279 4.15677 6.05312 4.07837L2.12785 0.247421C2.04818 0.169022 1.95338 0.106794 1.84895 0.0643287C1.74451 0.0218632 1.63249 0 1.51935 0C1.40621 0 1.29419 0.0218632 1.18975 0.0643287C1.08531 0.106794 0.990517 0.169022 0.910844 0.247421C0.751218 0.404141 0.661621 0.616141 0.661621 0.837119C0.661621 1.0581 0.751218 1.2701 0.910844 1.42682L4.84468 5.26613C5.32677 5.73605 5.98027 6 6.66162 6C7.34297 6 7.99647 5.73605 8.47856 5.26613L12.4124 1.42682C12.572 1.2701 12.6616 1.0581 12.6616 0.837119C12.6616 0.616141 12.572 0.404141 12.4124 0.247421Z" fill="#374557" fill-opacity="0.6"></path></svg></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row nftmax-gap-sq30">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-1.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-2.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-3.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Photography</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-4.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-5.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-6.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Amazing Game</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-7.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-8.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-9.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Arts</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-10.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-11.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-12.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Photography</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-13.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-14.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-15.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Domin</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-16.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-17.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-18.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Sports</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-19.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-20.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-21.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Cards</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-22.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-23.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-24.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Uitily</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="nftmax-collection__single">
                                                <div class="nftmax-collection__head">
                                                    <a href="#"><img src="img/col-25.png" alt="#"></a>
                                                </div>
                                                <div class="nftmax-collection__body">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-26.png" alt="#"></a>
                                                        </div>
                                                        <div class="col-6">
                                                            <a href="#"><img src="img/col-27.png" alt="#"></a>
                                                        </div>
                                                    </div>
                                                    <div class="nftmax-collection__author">
                                                        <div class="nftmax-collection__author-head">
                                                            <a href="#">
                                                                <img src="img/market-author-2.png" alt="#">
                                                                <h4 class="nftmax-collection__title">Virtural Worlds</h4>
                                                            </a>
                                                        </div>
                                                        <div class="nftmax-collection__item"><a href="#">324 Item</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_6" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="nftmax-pptabs mg-btm-20">
                                                <div class="nftmax-pptabs__form">
                                                    <form class="nftmax-header__form-inner nftmax-header__form-profile" action="#">
                                                        <button class="search-btn" type="submit"><img src="img/search.png" alt="#"></button>
                                                        <input name="s" value="" type="text" placeholder="Search items, collections...">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nftmax-table">
                                        <div class="nftmax-table__heading">
                                            <h3 class="nftmax-table__title mb-0">Products History</h3>
                                            <ul class="nav nav-tabs  nftmax-dropdown__list" id="nav-tab" role="tablist">
                                                <li class="nav-item dropdown ">
                                                    <a class="nftmax-sidebar_btn nftmax-heading__tabs nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">All Categories <span class="nftmax-table__arrow--icon"><svg width="13" height="6" viewBox="0 0 13 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.7" d="M12.4124 0.247421C12.3327 0.169022 12.2379 0.106794 12.1335 0.0643287C12.0291 0.0218632 11.917 0 11.8039 0C11.6908 0 11.5787 0.0218632 11.4743 0.0643287C11.3699 0.106794 11.2751 0.169022 11.1954 0.247421L7.27012 4.07837C7.19045 4.15677 7.09566 4.219 6.99122 4.26146C6.88678 4.30393 6.77476 4.32579 6.66162 4.32579C6.54848 4.32579 6.43646 4.30393 6.33202 4.26146C6.22758 4.219 6.13279 4.15677 6.05312 4.07837L2.12785 0.247421C2.04818 0.169022 1.95338 0.106794 1.84895 0.0643287C1.74451 0.0218632 1.63249 0 1.51935 0C1.40621 0 1.29419 0.0218632 1.18975 0.0643287C1.08531 0.106794 0.990517 0.169022 0.910844 0.247421C0.751218 0.404141 0.661621 0.616141 0.661621 0.837119C0.661621 1.0581 0.751218 1.2701 0.910844 1.42682L4.84468 5.26613C5.32677 5.73605 5.98027 6 6.66162 6C7.34297 6 7.99647 5.73605 8.47856 5.26613L12.4124 1.42682C12.572 1.2701 12.6616 1.0581 12.6616 0.837119C12.6616 0.616141 12.572 0.404141 12.4124 0.247421Z" fill="#374557" fill-opacity="0.6"></path></svg></span></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- NFTMax Table -->
                                        <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__profile-activity">
                                            <!-- NFTMax Table Head -->
                                            <thead class="nftmax-table__head">
                                                <tr>
                                                    <th class="nftmax-table__column-1 nftmax-table__h1">List</th>
                                                    <th class="nftmax-table__column-2 nftmax-table__h2">Products Name</th>
                                                    <th class="nftmax-table__column-3 nftmax-table__h2">Price</th>
                                                    <th class="nftmax-table__column-4 nftmax-table__h3">Quanitiy</th>
                                                    <th class="nftmax-table__column-5 nftmax-table__h4">From</th>
                                                    <th class="nftmax-table__column-6 nftmax-table__h5">To</th>
                                                    <th class="nftmax-table__column-7 nftmax-table__h6">Time</th>
                                                </tr>
                                            </thead>
                                            <!-- NFTMax Table Body -->
                                            <tbody class="nftmax-table__body">
                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>01</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Mullican Computer Joy</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Marvin McKinney</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>02</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img2.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">View Card by Jeff Davis</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Jerome Bell</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>03</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Spanky &amp; Friends</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Savannah Nguyen</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>04</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Intercnected Planes</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Eleanor Pena</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>05</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img1.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Mullican Computer Joy</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Marvin McKinney</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>06</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img2.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">View Card by Jeff Davis</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Jerome Bell</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>07</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Spanky &amp; Friends</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Savannah Nguyen</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>08</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Intercnected Planes</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Eleanor Pena</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>09</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Spanky &amp; Friends</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Savannah Nguyen</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="nftmax-table__column-1 nftmax-table__data-1">
                                                        <span class="nftmax-table__text"><b>10</b></span>
                                                    </td>
                                                    <td class="nftmax-table__column-2 nftmax-table__data-2">
                                                        <div class="nftmax-table__product">
                                                            <div class="nftmax-table__product-img">
                                                                <img src="img/nft-table-img3.png" alt="#">
                                                            </div>
                                                            <div class="nftmax-table__product-content">
                                                                <h4 class="nftmax-table__product-title">Intercnected Planes</h4>
                                                                <p class="nftmax-table__product-desc">Owned by  <a href="#">Xoeyam</a></p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-3 nftmax-table__data-3">
                                                        <div class="nftmax-table__amount nftmax-table__text-two">
                                                            <img src="img/usd-icon.png" alt="#"><span class="nftmax-table__text">6392.99$</span>
                                                        </div>
                                                    </td>
                                                    <td class="nftmax-table__column-4 nftmax-table__data-4">
                                                        <p class="nftmax-table__text nftmax-table__bid-text">343</p>
                                                    </td>
                                                    <td class="nftmax-table__column-5 nftmax-table__data-5">
                                                        <p class="nftmax-table__text nftmax-table__bid-text"><a href="#">Eleanor Pena</a></p>
                                                    </td>
                                                    <td class="nftmax-table__column-6 nftmax-table__data-6">
                                                        <p class="nftmax-table__text nftmax-table__time">you</p>
                                                    </td>
                                                    <td class="nftmax-table__column-7 nftmax-table__data-7">
                                                        <p class="nftmax-table__time">2 days ago</p>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <!-- End NFTMax Table Body -->
                                        </table>
                                        <!-- End NFTMax Table -->
                                    </div>
                                </div> --}}

                            </div>


                        </div>

                    </div>
                    <!-- End Dashboard Inner -->
                </div>
            </div>


        </div>
    </div>
</section>
{{-- <div class="nftmax-profile__container">
    <div class="nftmax-profile__header">
        <h1>My Profile</h1>
    </div>
    <div class="nftmax-profile__details">
        <div class="nftmax-profile__item">
            <h3>Name:</h3>
            <p>{{ $user->name }}</p>
        </div>
        <div class="nftmax-profile__item">
            <h3>Email:</h3>
            <p>{{ $user->email }}</p>
        </div>
        <div class="nftmax-profile__item">
            <h3>Role:</h3>
            <p>{{ $user->getRoleNames()->implode(', ') }}</p>
        </div>
        <a href="{{ route('user.profile.edit') }}" class="nftmax-btn nftmax-btn__primary">Edit Profile</a>
    </div>
</div> --}}
@endsection
