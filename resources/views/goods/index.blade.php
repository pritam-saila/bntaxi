<!doctype html>
<html lang="en-GB">
    <head>
         <meta charset="UTF-8">
         <title>BN Taxi Anytime | Brighton Taxi & Airport Transfers </title>
  <meta name="description" content="Reliable Brighton taxi service, available 24/7. Airport transfers, wedding cars & corporate travel with fixed prices. Book your ride online now.">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <link rel="preload" as="image" href="{{ url('goods/images/bntaxi1.webp') }}"
              imagesrcset="{{ url('goods/images/bntaxi1-800.webp') }} 800w, {{ url('goods/images/bntaxi1.webp') }} 1600w"
              imagesizes="100vw" fetchpriority="high">
        @include('goods.include.assets', [
            'lean' => true,
            'ogTitle' => 'BN Taxi Anytime | Brighton Taxi & Airport Transfers',
            'ogDescription' => '24/7 Brighton taxi service. Fixed-price airport transfers to Gatwick, Heathrow and more. Book online.',
        ])
        @include('goods.include.schema-taxi-service')


        @stylesheet('goods/css/pages/home.css')
    </head>
    <body>
        @include('goods.include.header')

        
            
            
<div class="bn-hero" id="bnHero" aria-roledescription="carousel" aria-label="BN Taxi Anytime highlights">
    <div class="bn-hero-track">
        <div class="bn-hero-slide" role="group" aria-roledescription="slide" aria-label="1 of 5">
            <img src="{{ url('goods/images/bntaxi1.webp') }}" srcset="{{ url('goods/images/bntaxi1-800.webp') }} 800w, {{ url('goods/images/bntaxi1.webp') }} 1600w" sizes="100vw" width="1600" height="667" fetchpriority="high" alt="BN Taxi Anytime - book your Brighton taxi in 4 easy steps">
        </div>
        <div class="bn-hero-slide" role="group" aria-roledescription="slide" aria-label="2 of 5" aria-hidden="true">
            <img data-src="{{ url('goods/images/banner2nd.webp') }}" data-srcset="{{ url('goods/images/banner2nd-800.webp') }} 800w, {{ url('goods/images/banner2nd.webp') }} 1600w" sizes="100vw" width="1600" height="667" decoding="async" alt="BN Taxi Anytime airport transfers">
        </div>
        <div class="bn-hero-slide" role="group" aria-roledescription="slide" aria-label="3 of 5" aria-hidden="true">
            <img data-src="{{ url('goods/images/banner33.webp') }}" data-srcset="{{ url('goods/images/banner33-800.webp') }} 800w, {{ url('goods/images/banner33.webp') }} 1600w" sizes="100vw" width="1600" height="667" decoding="async" alt="BN Taxi Anytime fixed price taxis">
        </div>
        <div class="bn-hero-slide" role="group" aria-roledescription="slide" aria-label="4 of 5" aria-hidden="true">
            <img data-src="{{ url('goods/images/banner4.webp') }}" data-srcset="{{ url('goods/images/banner4-800.webp') }} 800w, {{ url('goods/images/banner4.webp') }} 1600w" sizes="100vw" width="1600" height="667" decoding="async" alt="BN Taxi Anytime professional drivers">
        </div>
        <div class="bn-hero-slide" role="group" aria-roledescription="slide" aria-label="5 of 5" aria-hidden="true">
            <img data-src="{{ url('goods/images/banner5.webp') }}" data-srcset="{{ url('goods/images/banner5-800.webp') }} 800w, {{ url('goods/images/banner5.webp') }} 1600w" sizes="100vw" width="1600" height="667" decoding="async" alt="BN Taxi Anytime 24/7 taxi service">
        </div>
    </div>
    <button type="button" class="bn-hero-btn bn-hero-prev" aria-label="Previous slide">&#8249;</button>
    <button type="button" class="bn-hero-btn bn-hero-next" aria-label="Next slide">&#8250;</button>
    <div class="bn-hero-dots"></div>
</div>

            <div class="banner_bottom">
                <div class="container">
                    <h1>
                        Brighton Taxi &amp; Airport Transfers, 24/7 &middot; Get a FREE Instant Quote <span><a href="{{url('book-now')}}">Book Now</a></span>
                    </h1>
                </div>
            </div>

            @include('goods.include.get-a-quote')

           <section class="airport-section">

    <div class="container">

        <div class="airport-title">
            <h2>
                Brighton and Hove Taxis and Airport Transfers
            </h2>
        </div>


        <div class="airport-wrapper">


            <!-- =================================================
                 LEFT SIDE - AIRPORT PRICES
                 ================================================= -->

            <div class="airport-left">

                <ul>

                    <li>
                        <strong>Gatwick Airport</strong>
                        <span>From £75</span>
                    </li>

                    <li>
                        <strong>Heathrow Airport</strong>
                        <span>From £145</span>
                    </li>

                    <li>
                        <strong>Luton Airport</strong>
                        <span>From £245</span>
                    </li>

                    <li>
                        <strong>London Stansted Airport</strong>
                        <span>From £245</span>
                    </li>

                    <li>
                        <strong>London City Airport</strong>
                        <span>From £200</span>
                    </li>

                    <li>
                        <strong>London St Pancras (rail station)</strong>
                        <span>From £245</span>
                    </li>

                </ul>


                <p class="note">
                    For more prices to other destinations,
                    larger vehicles click below.
                </p>


                <a
                    href="tel:+441273757373"
                    class="btn-call"
                >
                    Call Now
                </a>

            </div>


            <!-- =================================================
                 RIGHT SIDE - INFORMATION
                 ================================================= -->

            <div class="airport-right">

                <p>
                    Welcome to Brighton’s leading mini-cab service.
                    Counted as a specialist airport taxi company,
                    we have a wealth of experience in providing
                    first-class airport transfers in Brighton at
                    competitive prices.
                </p>


                <p>
                    What sets us apart is our swift response times,
                    accurate estimates and a large fleet of vehicles
                    to choose from.
                </p>


                <p>
                    Book airport taxi in Brighton now to experience
                    the highest quality of customer service and be
                    assured of reaching your destinations on time!
                </p>


                <a
                    href="{{url('book-now')}}"
                    class="btn-book"
                >
                    Book Now
                </a>

            </div>


        </div>

    </div>

</section>

            <!--        <section class="hero-fixed">-->
            <!--    <div class="hero-overlay"></div>-->

            <!--    <div class="hero-content">-->
            <!--        <h1>BN Taxi Anytime</h1>-->
            <!--        <p>-->
            <!--            Fast, reliable & affordable taxi service available 24/7.-->
            <!--            Book your ride anytime, anywhere with comfort.-->
            <!--        </p>-->

            <!--        <div class="hero-btns">-->
            <!--            <a href="#" class="btn-main">Book Now</a>-->
            <!--            <a href="#" class="btn-light">Learn More</a>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</section>-->

            <section class="why-section">

    <div class="container">

        <div class="why-header">

            <h2>
                Why Choose Us
            </h2>

            <p>
                We are a team of dedicated professionals devoted to providing the ultimate customer
                satisfaction. We believe that resolute customer service is the gateway to success.
                Brighton taxis have come up only because of these values.
            </p>

        </div>


        <div class="why-grid">


            <!-- PROFESSIONAL CHAUFFEURS -->

            <div class="why-card">

                <div class="why-icon">
                    <i class="fas fa-user-tie"></i>
                </div>

                <h3>
                    Professional Chauffeurs
                </h3>

                <p>
                    Our drivers at Brighton Taxis carry valid license and have an excellent amount of
                    driving experience. We provide professional chauffeurs at your service.
                </p>

            </div>


            <!-- CLEAR PRICES -->

            <div class="why-card">

                <div class="why-icon">
                    <i class="fas fa-tags"></i>
                </div>

                <h3>
                    Clear Prices
                </h3>

                <p>
                    BN Taxi Anytime follows a guiding ethical principle. Our taxi service by Brighton taxis
                    incurs no hidden charges. Likewise, we provide an accurate estimate for the provided
                    service.
                </p>

            </div>


            <!-- RELIABLE SERVICE -->

            <div class="why-card">

                <div class="why-icon">
                    <i class="fas fa-clock"></i>
                </div>

                <h3>
                    Reliable Service
                </h3>

                <p>
                    Brighton Taxis is the name that you can rely on if you are planning to hire a Brighton
                    airport transfer service. The company is dedicated to providing timely service. This is
                    the crucial reason for our success.
                </p>

            </div>


            <!-- FREE CANCELLATION -->

            <div class="why-card">

                <div class="why-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>

                <h3>
                    Free Cancellation
                </h3>

                <p>
                    We do not charge a single amount if you cancel the Brighton taxis within 6 hours period.
                    No other company provides such a facility except the Brighton taxis all over the UK.
                </p>

            </div>


        </div>

    </div>

</section>

            <section class="testimonial_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="about_content">
                                <div class="background_layer"></div>
                                <div class="layer_content">
                                    <div class="section_title">
                                        <div class="bn-about-kicker">ABOUT US</div>
                                        <h2>{{ $about->heading ?? 'Brighton Taxi Company' }}</h2>
                                        <div class="heading_line"><span></span></div>
                                       <p> {!! \Illuminate\Support\Str::limit(strip_tags($about->description ?? '<p>BN Taxi anytime</p>'), 700) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            @stylesheet('goods/css/pages/home-testimonials.css')

                            <div class="bn-tm-wrap">
                                <div class="bn-tm-badge">
                                    <img src="{{ url('goods/images/logo.png') }}" width="288" height="100" loading="lazy" alt="BN Taxi Anytime" onerror="this.style.display='none'">
                                </div>
                                <div class="bn-tm-head">
                                    <span class="bn-tm-kicker">TESTIMONIALS</span>
                                    <h3>What our passengers say</h3>
                                </div>

                                <div class="bn-tm-nav">
                                    <button type="button" class="bn-tm-prev" aria-label="Previous testimonial"><i class="fas fa-arrow-left" aria-hidden="true"></i></button>
                                    <button type="button" class="bn-tm-next" aria-label="Next testimonial"><i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                                </div>

                                <div class="swiper testimonialSwiper">
                                    <div class="swiper-wrapper">
                                        @forelse($testimonials as $testimonial)
                                            <div class="swiper-slide">
                                                <article class="bn-tm-card">
                                                    <div class="bn-tm-quotemark">&ldquo;</div>
                                                    <div class="bn-tm-stars" aria-hidden="true">
                                                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                    </div>
                                                    <p class="bn-tm-text">{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($testimonial->description), ENT_QUOTES | ENT_HTML5))), 240) }}</p>
                                                    <div class="bn-tm-person">
                                                        <img class="bn-tm-avatar" src="{{ $testimonial->image ? url(Storage::url($testimonial->image)) : url('goods/images/test.jpg') }}" alt="{{ $testimonial->title }}" loading="lazy">
                                                        <div class="bn-tm-meta">
                                                            <strong>{{ $testimonial->title }}</strong>
                                                            @if($testimonial->designation)<span>{{ $testimonial->designation }}</span>@endif
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        @empty
                                            <div class="swiper-slide">
                                                <article class="bn-tm-card">
                                                    <p class="bn-tm-text">Trusted by passengers across Brighton &amp; Hove for reliable, professional journeys.</p>
                                                </article>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="swiper-pagination bn-tm-pagination"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- <div class="simplify">
  		<div class="container">
  			<div class="col-md-6">
  				<div class="design">
  					<img src="{{url('goods')}}/images/design.png">
  				</div>
  			</div>
  			<div class="col-md-6">
  				<div class="design">
  					<h2>Simplify Your Logistics with Our Online Portal</h2>
  				</div>
  			</div>
  		</div>
  	</div> -->

            <div class="bn-map" data-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2519.4320217800564!2d-0.12533568826761446!3d50.84168367155134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487585893d3c75f3%3A0xdf0cf8b8d9f5aee8!2sSaunders%20Park%20View%2C%20Brighton%20and%20Hove%2C%20Brighton%2C%20UK!5e0!3m2!1sen!2sin!4v1775154471291!5m2!1sen!2sin">
                <button type="button" class="bn-map-btn"><i class="fas fa-map-marker-alt" aria-hidden="true"></i> Show our location on Google Maps</button>
            </div>
        </div>

        @include('goods.include.footer')

        <script>
        /* Hero slider: tiny replacement for Swiper (autoplay, arrows, dots, swipe). */
        (function () {
            var root = document.getElementById('bnHero');
            if (!root) return;
            var track = root.querySelector('.bn-hero-track');
            var slides = root.querySelectorAll('.bn-hero-slide');
            var dotsBox = root.querySelector('.bn-hero-dots');
            var n = slides.length, i = 0, timer = null, DELAY = 4000;

            function hydrate(k) {
                var img = slides[k] && slides[k].querySelector('img[data-src]');
                if (!img) return;
                img.srcset = img.getAttribute('data-srcset');
                img.src = img.getAttribute('data-src');
                img.removeAttribute('data-src');
                img.removeAttribute('data-srcset');
            }

            var dots = [];
            for (var k = 0; k < n; k++) {
                var b = document.createElement('button');
                b.type = 'button';
                b.setAttribute('aria-label', 'Go to slide ' + (k + 1));
                b.addEventListener('click', (function (k) { return function () { go(k); restart(); }; })(k));
                dotsBox.appendChild(b);
                dots.push(b);
            }

            function go(k) {
                i = (k + n) % n;
                hydrate(i);
                hydrate((i + 1) % n);
                track.style.transform = 'translateX(' + (-100 * i) + '%)';
                for (var j = 0; j < n; j++) {
                    dots[j].setAttribute('aria-current', j === i ? 'true' : 'false');
                    if (j === i) slides[j].removeAttribute('aria-hidden');
                    else slides[j].setAttribute('aria-hidden', 'true');
                }
            }

            function restart() {
                clearInterval(timer);
                timer = setInterval(function () { go(i + 1); }, DELAY);
            }

            root.querySelector('.bn-hero-prev').addEventListener('click', function () { go(i - 1); restart(); });
            root.querySelector('.bn-hero-next').addEventListener('click', function () { go(i + 1); restart(); });

            var x0 = null;
            root.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
            root.addEventListener('touchend', function (e) {
                if (x0 === null) return;
                var dx = e.changedTouches[0].clientX - x0;
                x0 = null;
                if (Math.abs(dx) > 40) { go(i + (dx < 0 ? 1 : -1)); restart(); }
            }, { passive: true });

            // Set up dots without fetching extra banners yet.
            for (var j = 0; j < n; j++) dots[j].setAttribute('aria-current', j === 0 ? 'true' : 'false');

            // Start rotating (and fetch the other banners) only after the page has finished loading.
            window.addEventListener('load', function () {
                setTimeout(function () { hydrate(1); restart(); }, 1500);
            });
        })();

        /* Load Swiper only when the testimonials come near the screen. */
        (function () {
            var el = document.querySelector('.testimonialSwiper');
            if (!el) return;
            var started = false;

            function start() {
                if (started) return;
                started = true;
                var css = document.createElement('link');
                css.rel = 'stylesheet';
                css.href = 'https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.css';
                document.head.appendChild(css);
                var js = document.createElement('script');
                js.src = 'https://cdn.jsdelivr.net/npm/swiper@11.1.14/swiper-bundle.min.js';
                js.onload = function () {
                    var tmSwiper = new Swiper(el, {
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: false,
                        rewind: true,
                        autoHeight: true,
                        speed: 650,
                        grabCursor: true,
                        observer: true,
                        observeParents: true,
                        resizeObserver: true,
                        autoplay: { delay: 5500, disableOnInteraction: false, pauseOnMouseEnter: true },
                        pagination: { el: '.bn-tm-pagination', clickable: true },
                        navigation: { nextEl: '.bn-tm-next', prevEl: '.bn-tm-prev' },
                    });
                    setTimeout(function () { tmSwiper.update(); }, 250);
                };
                document.body.appendChild(js);
            }

            if ('IntersectionObserver' in window) {
                var io = new IntersectionObserver(function (entries) {
                    if (entries.some(function (e) { return e.isIntersecting; })) { io.disconnect(); start(); }
                }, { rootMargin: '300px 0px' });
                io.observe(el);
            } else {
                start();
            }
        })();

        /* Google map: only embed it when it is about to be seen (or clicked). */
        (function () {
            var box = document.querySelector('.bn-map');
            if (!box) return;

            function load() {
                if (box.querySelector('iframe')) return;
                var f = document.createElement('iframe');
                f.src = box.getAttribute('data-src');
                f.title = 'BN Taxi Anytime location on Google Maps';
                f.referrerPolicy = 'no-referrer-when-downgrade';
                f.allowFullscreen = true;
                box.innerHTML = '';
                box.appendChild(f);
            }

            box.querySelector('.bn-map-btn').addEventListener('click', load);
            if ('IntersectionObserver' in window) {
                var io = new IntersectionObserver(function (entries) {
                    if (entries.some(function (e) { return e.isIntersecting; })) { io.disconnect(); load(); }
                }, { rootMargin: '200px 0px' });
                io.observe(box);
            }
        })();
        </script>
        
        

    </body>
</html>
