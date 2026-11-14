@stylesheet('goods/css/partials/header.css')
</style>





<header class="bn-premium-header">

    <div class="container">

        <div class="bn-header-inner">

            <!-- =====================================
                 LOGO
            ====================================== -->

            <div class="bn-header-logo">

                <a href="{{ url('/') }}">

                    <img
                        src="{{ url('goods') }}/images/logo.png"
                        alt="BN Taxi Anytime"
                    >

                </a>

                <!-- MOBILE MENU -->

                <button
                    type="button"
                    class="bn-mobile-menu-btn"
                    onclick="openNav()"
                    aria-label="Open Menu"
                >
                    <i class="fas fa-bars"></i>
                </button>

            </div>



            <!-- =====================================
                 MOBILE CALL
            ====================================== -->

            <div class="bn-mobile-call">

                <a href="tel:+441273757373">

                    <span class="bn-mobile-call-icon">
                        <i class="fas fa-phone-alt"></i>
                    </span>

                    <span class="bn-mobile-call-details">
                        <small>Call BN Taxi</small>
                        <strong>01273 757373</strong>
                    </span>

                    <span class="bn-mobile-247">
                        <i class="fas fa-clock"></i>
                        <strong>24/7</strong>
                        <small>AVAILABLE</small>
                    </span>

                </a>

            </div>



            <!-- =====================================
                 NAVIGATION
            ====================================== -->

            <nav class="bn-main-nav">

                <ul class="bn-navigation">

                    <li>
                        <a href="{{ url('') }}">
                            Home
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('about') }}">
                            About Us
                        </a>
                    </li>



                    <!-- SERVICES -->

                    <li class="bn-nav-dropdown">

                        <a
                            href="#"
                            class="bn-dropdown-toggle"
                        >
                            Services
                            <i class="fas fa-chevron-down"></i>
                        </a>


                        <ul class="bn-dropdown-menu">

                            @php
                                $services = App\Models\Service::all();
                            @endphp


                            @if(isset($services) && count($services) > 0)

                                @foreach($services as $service)

                                    <li>

                                        <a
                                            href="{{ url('/service-details/'.$service->slug) }}"
                                        >

                                            <span class="bn-dropdown-icon">
                                                <i class="fas fa-taxi"></i>
                                            </span>

                                            <span>
                                                {{ $service->title }}
                                            </span>

                                            <i class="fas fa-arrow-right"></i>

                                        </a>

                                    </li>

                                @endforeach

                            @else

                                <li>

                                    <a href="#" class="bn-disabled-link">

                                        <span class="bn-dropdown-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </span>

                                        No Services Available

                                    </a>

                                </li>

                            @endif

                        </ul>

                    </li>



                    <li>
                        <a href="{{ url('faq') }}">
                            FAQs
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('news') }}">
                            Blog
                        </a>
                    </li>


                    <li>
                        <a href="{{ url('contact') }}">
                            Contact Us
                        </a>
                    </li>



                    <!-- BOOK NOW -->

                    <li class="bn-book-nav">

                        <a href="{{ url('book-now') }}">

                            <span class="bn-book-icon">
                                <i class="fas fa-taxi"></i>
                            </span>

                            Book Now

                            <i class="fas fa-arrow-right"></i>

                        </a>

                    </li>


                    <li>
                        <a href="{{ url('gallery') }}">
                            Gallery
                        </a>
                    </li>



                    <!-- LOGIN -->

                    @if(!auth()->user())

                        <li class="bn-nav-dropdown bn-login-nav">

                            <a
                                href="#"
                                class="bn-dropdown-toggle"
                            >

                                <span class="bn-user-icon">
                                    <i class="fas fa-user"></i>
                                </span>

                                Login

                                <i class="fas fa-chevron-down"></i>

                            </a>


                            <ul class="bn-dropdown-menu bn-login-dropdown">

                                <li>

                                    <a href="{{ url('/user-login') }}">

                                        <span class="bn-dropdown-icon customer">
                                            <i class="fas fa-user"></i>
                                        </span>

                                        <span>
                                            <strong>Customer Login</strong>
                                            <small>Manage your bookings</small>
                                        </span>

                                    </a>

                                </li>


                                <li>

                                    <a href="{{ url('/driver-login') }}">

                                        <span class="bn-dropdown-icon driver">
                                            <i class="fas fa-car"></i>
                                        </span>

                                        <span>
                                            <strong>Driver Login</strong>
                                            <small>Driver account access</small>
                                        </span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @else

                        <li class="bn-account-nav">

                            <a href="{{ url('/user-account') }}">

                                <span class="bn-account-icon">
                                    <i class="fas fa-user"></i>
                                </span>

                                My Account

                            </a>

                        </li>

                    @endif

                </ul>

            </nav>

        </div>

    </div>

</header>

<script>

function openNav(){
    document.getElementById("mySidenav").classList.add("active");
    document.getElementById("overlay").classList.add("active");
}

function closeNav(){
    document.getElementById("mySidenav").classList.remove("active");
    document.getElementById("overlay").classList.remove("active");
}

</script>