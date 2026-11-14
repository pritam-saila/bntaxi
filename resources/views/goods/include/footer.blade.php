@stylesheet('goods/css/partials/footer.css')


<!-- =========================================
     BN TAXI - POPULAR ROUTES
========================================= -->

<section class="bn-routes-section">

    <div class="bn-routes-bg-shape bn-routes-shape-1"></div>
    <div class="bn-routes-bg-shape bn-routes-shape-2"></div>

    <div class="container">

        <!-- Heading -->
        <div class="bn-routes-heading">

            <span class="bn-routes-eyebrow">
                <i class="fas fa-route"></i>
                BN TAXI SERVICES
            </span>

            <h2>
                Popular <span>Taxi Routes</span>
            </h2>

            <p>
                Explore our most popular taxi routes across Brighton,
                Sussex and surrounding areas.
            </p>

        </div>


        @php
            $routehandles = App\Models\Routehandle::all();

            /*
             * Divide routes into 3 balanced columns.
             * This is better than split(3), which can create
             * uneven columns when the route count changes.
             */
            $routeCount = $routehandles->count();

            $perColumn = $routeCount > 0
                ? (int) ceil($routeCount / 3)
                : 1;

            $routeChunks = $routehandles->chunk($perColumn);
        @endphp


        @if($routeCount > 0)

            <div class="bn-routes-grid">

                @foreach($routeChunks as $chunk)

                    <div class="bn-route-card">

                        <div class="bn-route-card-top">

                            <div class="bn-route-icon">
                                <i class="fas fa-taxi"></i>
                            </div>

                            <span class="bn-route-card-label">
                                Taxi Routes
                            </span>

                        </div>


                        <div class="bn-route-list">

                            @foreach($chunk as $route)

                                <a
                                    href="{{ url('/route-details/'.$route->slug) }}"
                                    class="bn-route-item"
                                >

                                    <span class="bn-route-arrow">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>

                                    <span class="bn-route-name">
                                        {{ $route->title }}
                                    </span>

                                    <span class="bn-route-link-icon">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>

                                </a>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="bn-routes-empty">

                <div class="bn-routes-empty-icon">
                    <i class="fas fa-route"></i>
                </div>

                <h3>No Taxi Routes Available</h3>

                <p>
                    Popular taxi routes will appear here soon.
                </p>

            </div>

        @endif


        <!-- Bottom CTA -->
        <div class="bn-routes-cta">

            <div class="bn-routes-cta-icon">
                <i class="fas fa-car"></i>
            </div>

            <div class="bn-routes-cta-content">
                <strong>Need a taxi somewhere else?</strong>
                <span>
                    Get in touch with BN Taxi Anytime for your journey.
                </span>
            </div>

            <a href="{{ url('/book-now') }}" class="bn-routes-cta-btn">
                Book a Taxi
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>

</section>

<footer class="bn-footer">

    <!-- TOP ACCENT -->
    <div class="bn-footer-accent"></div>

    <div class="container">

        <div class="bn-footer-grid">

            <!-- =====================================
                 LOGO + ABOUT
            ====================================== -->
            <div class="bn-footer-col bn-footer-about">

                <a href="{{ url('') }}" class="bn-footer-brand">

                    <span class="bn-brand-icon">
                        <i class="fa fa-taxi"></i>
                    </span>

                    <span class="bn-brand-text">
                        <strong>BN TAXI</strong>
                        <small>ANYTIME</small>
                    </span>

                </a>


                <p class="bn-footer-description">
                    BN Taxi Anytime provides safe, reliable and affordable
                    taxi service across Brighton and surrounding areas.
                    Available 24/7 for your convenience.
                </p>


                <!-- CONTACT -->
                <div class="bn-contact">

                    <a href="tel:+441273757373">

                        <span class="bn-contact-icon">
                            <i class="fa fa-phone"></i>
                        </span>

                        <span>
                            <small>Call Us 24/7</small>
                            01273 757373
                        </span>

                    </a>


                    <a href="mailto:info@bntaxianytime.com">

                        <span class="bn-contact-icon">
                            <i class="fa fa-envelope"></i>
                        </span>

                        <span>
                            <small>Email Us</small>
                            info@bntaxianytime.com
                        </span>

                    </a>

                </div>


                <!-- SOCIAL -->
                <div class="bn-footer-social">

                    {{-- Only profiles with a real URL are shown (set them in .env, see config/services.php). --}}
                    @php $biz = config('services.business'); @endphp
                    @foreach ([
                        ['facebook_url', 'Facebook', 'fab fa-facebook'],
                        ['instagram_url', 'Instagram', 'fab fa-instagram'],
                        ['twitter_url', 'X (Twitter)', 'fab fa-twitter'],
                        ['whatsapp_url', 'WhatsApp', 'fab fa-whatsapp'],
                    ] as [$key, $label, $icon])
                        @if (!empty($biz[$key]))
                            <a href="{{ $biz[$key] }}" target="_blank" rel="noopener" aria-label="BN Taxi Anytime on {{ $label }}">
                                <i class="{{ $icon }}" aria-hidden="true"></i>
                            </a>
                        @endif
                    @endforeach

                </div>

            </div>


            <!-- =====================================
                 QUICK LINKS
            ====================================== -->
            <div class="bn-footer-col">

                <h3>
                    <span class="bn-title-line"></span>
                    Quick Links
                </h3>

                <ul>

                    <li>
                        <a href="{{ url('') }}">
                            <i class="fa fa-angle-right"></i>
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('about') }}">
                            <i class="fa fa-angle-right"></i>
                            About Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('faq') }}">
                            <i class="fa fa-angle-right"></i>
                            FAQs
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('news') }}">
                            <i class="fa fa-angle-right"></i>
                            Blog
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('contact') }}">
                            <i class="fa fa-angle-right"></i>
                            Contact Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('book-now') }}">
                            <i class="fa fa-angle-right"></i>
                            Book Now
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('gallery') }}">
                            <i class="fa fa-angle-right"></i>
                            Gallery
                        </a>
                    </li>

                </ul>

            </div>


            <!-- =====================================
                 SERVICES
            ====================================== -->
            <div class="bn-footer-col">

                <h3>
                    <span class="bn-title-line"></span>
                    Our Services
                </h3>

                <ul>

                    @php
                        $routehandles = App\Models\Service::all();
                    @endphp

                    @if(isset($routehandles) && count($routehandles) > 0)

                        @foreach($routehandles as $route)

                            <li>
                                <a href="{{ url('/route-details/'.$route->slug) }}">
                                    <i class="fa fa-angle-right"></i>
                                    {{ $route->title }}
                                </a>
                            </li>

                        @endforeach

                    @else

                        <li>
                            <span class="bn-no-service">
                                No services available
                            </span>
                        </li>

                    @endif

                </ul>

            </div>


            <!-- =====================================
                 ADDRESS + BOOKING
            ====================================== -->
            <div class="bn-footer-col bn-footer-location">

                <h3>
                    <span class="bn-title-line"></span>
                    Find Us
                </h3>


                <!-- ADDRESS CARD -->
                <div class="bn-address-card">

                    <div class="bn-address-icon">
                        <i class="fa fa-map-marker"></i>
                    </div>

                    <div>

                        <small>Our Location</small>

                        <p>
                            @if (config('services.business.street_address'))
                                {{ config('services.business.street_address') }},<br>
                            @else
                                Saunders Park,<br>
                            @endif
                            Brighton {{ config('services.business.postcode') }},<br>
                            United Kingdom
                        </p>

                    </div>

                </div>


                <!-- AVAILABLE -->
                <div class="bn-availability">

                    <span class="bn-online-dot"></span>

                    <div>
                        <strong>Available 24/7</strong>
                        <small>Ready when you are</small>
                    </div>

                </div>


                <!-- BOOK BUTTON -->
                <a
                    href="{{ url('book-now') }}"
                    class="bn-btn"
                >

                    <span>
                        <i class="fa fa-taxi"></i>
                    </span>

                    Book Your Taxi

                    <i class="fa fa-arrow-right bn-btn-arrow"></i>

                </a>

            </div>

        </div>


        <!-- =====================================
             SERVICE QUICK BAR
        ====================================== -->
        <div class="bn-footer-service-bar">

            <div class="bn-service-bar-title">

                <i class="fa fa-road"></i>

                <span>Popular Taxi Services</span>

            </div>


            <div class="bn-service-bar-links">

                <a href="{{ url('book-now') }}">
                    Brighton Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Airport Transfers
                </a>

                <a href="{{ url('book-now') }}">
                    Heathrow Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Gatwick Taxi
                </a>

                <a href="{{ url('book-now') }}">
                    Corporate Taxi
                </a>

            </div>

        </div>

    </div>


    <!-- =====================================
         COPYRIGHT
    ====================================== -->
    <div class="bn-footer-bottom">

        <div class="container">

            <div class="bn-footer-bottom-inner">

                <p>
                    &copy; {{ date('Y') }}
                    <strong>BN Taxi Anytime</strong>.
                    All Rights Reserved.
                </p>


                <div class="bn-social">

                    <a href="{{ url('privacy-policy') }}">
                        Privacy Policy
                    </a>

                    <span></span>

                    <a href="{{ url('terms-and-conditions') }}">
                        Terms and Conditions
                    </a>

                </div>

            </div>

        </div>

    </div>

</footer>

<div class="overlay" id="overlay" onclick="closeNav()"></div>







<!-- SIDENAV -->

<div id="mySidenav" class="sidenav">

    <div class="menu-top">

        <div class="close-btn" onclick="closeNav()">
            <i class="fa fa-times"></i>
        </div>

        <div class="profile">
            <!--<img src="https://i.pravatar.cc/150?img=12">-->

            <div class="profile-text">
                <h3>BN Taxi</h3>
                @auth
                <p>Welcome back 👋</p>
                @endauth
            </div>
        </div>

    </div>

    <div class="menu-links">

        <ul class="">

                        <a href="{{url('')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Home</a>
                        <a href="{{url('about')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> About Us</a>

                        <!-- Services Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Services
                            </a>

                            <ul class="dropdown-menu shadow border-0">
                                @php
                                    $services = App\Models\Service::all();
                                @endphp

                                @if(isset($services) && count($services) > 0)
                                    @foreach($services as $service)
                                        <li>
                                            <a class="dropdown-item" href="{{url('/service-details/'.$service->slug)}}">
                                                {{$service->title}}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <a class="dropdown-item text-muted" href="#">
                                            No Services Available
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <a href="{{url('faq')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Faqs</a>
                        <a href="{{url('news')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Blog</a>
                        <a href="{{url('contact')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Contact Us</a>
                        <a href="{{url('book-now')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Book Now</a>
                        <a href="{{url('gallery')}}"><i class="fa fa-arrow-right" aria-hidden="true"></i> Gallery</a>

                        <!-- Login Dropdown -->
                        @if(!auth()->user())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i> Login
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li>
                                    <a class="dropdown-item" href="{{url('/user-login')}}">
                                        <i class="fa fa-user me-2"></i> Customer Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{url('/driver-login')}}">
                                        <i class="fa fa-car me-2"></i> Driver Login
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @else
                            <li class="menubg">
                                <a href="{{url('/user-account')}}">My Account</a>
                            </li>
                        @endif

                    </ul>

    </div>

    <!--<div class="social-area">-->

    <!--    <div class="social-title">-->
    <!--        FOLLOW US-->
    <!--    </div>-->

    <!--    <div class="social-icons">-->

    <!--        <a href="#" class="fb">-->
    <!--            <i class="fab fa-facebook-f"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="insta">-->
    <!--            <i class="fab fa-instagram"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="yt">-->
    <!--            <i class="fab fa-youtube"></i>-->
    <!--        </a>-->

    <!--        <a href="#" class="whatsapp">-->
    <!--            <i class="fab fa-whatsapp"></i>-->
    <!--        </a>-->

    <!--    </div>-->

    <!--</div>-->

</div>



<script>

document.querySelectorAll('.dropdown-toggle').forEach(function(btn){

    btn.addEventListener('click', function(e){

        e.preventDefault();

        let menu = this.parentElement.querySelector('.dropdown-menu');

        if(menu.style.display === "block"){

            menu.style.display = "none";

        }else{

            menu.style.display = "block";

        }

    });

});

</script>


<script>
/* =========================================================
   BN TAXI - ROBUST SIDEBAR CONTROLS
   ========================================================= */

(function () {

    function getSidebar() {
        return document.getElementById("mySidenav");
    }

    function getOverlay() {
        return document.getElementById("overlay");
    }

    function openSidebar() {
        var sidebar = getSidebar();
        var overlay = getOverlay();

        if (sidebar) {
            sidebar.classList.add("bn-sidebar-open");
        }

        if (overlay) {
            overlay.classList.add("bn-overlay-open");
        }

        document.body.classList.add("bn-sidebar-active");
    }

    function closeSidebar() {
        var sidebar = getSidebar();
        var overlay = getOverlay();

        if (sidebar) {
            sidebar.classList.remove("bn-sidebar-open");
        }

        if (overlay) {
            overlay.classList.remove("bn-overlay-open");
        }

        document.body.classList.remove("bn-sidebar-active");
    }

    /* Make these available to the existing inline onclick attributes. */
    window.openNav = openSidebar;
    window.closeNav = closeSidebar;

    function bindSidebarEvents() {

        var closeBtn = document.querySelector(
            "#mySidenav .close-btn"
        );

        var overlay = document.getElementById("overlay");

        if (closeBtn) {
            closeBtn.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
                return false;
            };
        }

        if (overlay) {
            overlay.onclick = function (e) {
                e.preventDefault();
                closeSidebar();
                return false;
            };
        }

        /* Support common mobile menu buttons without changing markup. */
        var menuButtons = document.querySelectorAll(
            ".bn-mobile-menu-btn, .mobile-menu-btn, .menu-toggle, [data-menu-toggle]"
        );

        menuButtons.forEach(function (btn) {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                openSidebar();
            });
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", bindSidebarEvents);
    } else {
        bindSidebarEvents();
    }

    /* ESC closes the sidebar */
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeSidebar();
        }
    });

})();
</script>

<div class="whatsapp-position">
  <a id="wpClick" href="https://wa.me/447491757373" target="_blank" rel="noopener" aria-label="Chat with BN Taxi on WhatsApp"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>
</div>