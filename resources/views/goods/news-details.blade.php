<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $blog->title }}</title>
        <meta name="keywords" content="{{ $blog->metatag ?? '' }}">
        <meta name="description" content="{{ $blog->metadescription ?? '' }}">

        @include('goods.include.assets')
        
        @stylesheet('goods/css/pages/news-details.css')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
       <section class="bn-news-details-hero">

    <div class="bn-news-details-overlay"></div>

    <div class="container">

        <div class="bn-news-details-hero-content">

            <span class="bn-details-badge">
                <i class="fab fa-newspaper"></i>
                BN Taxi News
            </span>

            <h1>News Details</h1>

            <div class="bn-breadcrumb">

                <a href="{{ url('/') }}">
                    Home
                </a>

                <i class="fa fa-angle-right"></i>

                <a href="{{ url('/news') }}">
                    News
                </a>

                <i class="fa fa-angle-right"></i>

                <span>News Details</span>

            </div>

        </div>

    </div>

</section>


<section class="bn-news-details-section">

    <div class="container">

        <div class="row g-4 g-xl-5">


            <!-- =====================================
                 MAIN ARTICLE
            ====================================== -->

            <div class="col-lg-8">

                <article class="bn-news-article">

                    <!-- FEATURED IMAGE -->

                    <div class="bn-news-featured-image">

                        @if(!empty($blog->image))

                            <img
                                src="{{ url(Storage::url($blog->image)) }}"
                                alt="{{ $blog->title }}"
                                loading="eager"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-blog.jpg') }}';"
                            >

                        @else

                            <div class="bn-news-no-image">
                                <i class="fa fa-taxi"></i>
                            </div>

                        @endif


                        <div class="bn-featured-badge">
                            <i class="fa fa-taxi"></i>
                            BN Taxi
                        </div>

                    </div>


                    <!-- ARTICLE CONTENT -->

                    <div class="bn-news-article-content">

                        <!-- META -->

                        <div class="bn-news-meta">

                            <span>
                                <i class="fa fa-calendar"></i>

                                @if(!empty($blog->date))

                                    {{ \Carbon\Carbon::parse($blog->date)->format('M d, Y') }}

                                @elseif(!empty($blog->created_at))

                                    {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}

                                @else

                                    Date unavailable

                                @endif

                            </span>


                            <span class="bn-meta-separator"></span>


                            <span>
                                <i class="fa fa-car"></i>
                                BN Taxi Anytime
                            </span>

                        </div>


                        <!-- TITLE -->

                        <h2 class="bn-news-article-title">
                            {{ $blog->title }}
                        </h2>


                        <!-- DECORATIVE LINE -->

                        <div class="bn-article-title-line">

                            <span></span>

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="bn-blog-description">

                            {!! $blog->description !!}

                        </div>


                        <!-- ARTICLE FOOTER -->

                        <div class="bn-article-footer">

                            <div class="bn-article-share-text">
                                <i class="fa fa-share-alt"></i>
                                <span>Enjoyed this article?</span>
                            </div>


                            <a
                                href="{{ url('/news') }}"
                                class="bn-back-news"
                            >
                                <i class="fa fa-arrow-left"></i>
                                Back to News
                            </a>

                        </div>

                    </div>

                </article>


                <!-- BOOKING CTA -->

                <div class="bn-news-booking-cta">

                    <div class="bn-booking-cta-icon">

                        <i class="fa fa-taxi"></i>

                    </div>


                    <div class="bn-booking-cta-content">

                        <span>NEED A TAXI?</span>

                        <h3>
                            Travel with BN Taxi Anytime
                        </h3>

                        <p>
                            Safe, reliable and professional taxi service
                            available 24/7 across Brighton and surrounding areas.
                        </p>

                    </div>


                    <a
                        href="{{ url('/book-now') }}"
                        class="bn-booking-cta-button"
                    >
                        Book Now
                        <i class="fa fa-arrow-right"></i>
                    </a>

                </div>

            </div>



            <!-- =====================================
                 SIDEBAR
            ====================================== -->

            <div class="col-lg-4">

                <aside class="bn-news-sidebar">


                    <!-- RECENT NEWS -->

                    <div class="bn-sidebar-widget">

                        <div class="bn-sidebar-heading">

                            <div>

                                <span class="bn-sidebar-small-title">
                                    STAY UPDATED
                                </span>

                                <h3>
                                    Recent News
                                </h3>

                            </div>

                            <span class="bn-sidebar-heading-icon">
                                <i class="fa fa-newspaper-o"></i>
                            </span>

                        </div>


                        <div class="bn-recent-news-list">

                            @forelse($recent_blogs as $recent)

                                <a
                                    href="{{ url('/news/'.$recent->slug) }}"
                                    class="bn-recent-news"
                                >

                                    <!-- IMAGE -->

                                    <div class="bn-recent-image">

                                        @if(!empty($recent->image))

                                            <img
                                                src="{{ url(Storage::url($recent->image)) }}"
                                                alt="{{ $recent->title }}"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ asset('images/default-blog.jpg') }}';"
                                            >

                                        @else

                                            <div class="bn-recent-no-image">
                                                <i class="fa fa-taxi"></i>
                                            </div>

                                        @endif

                                    </div>


                                    <!-- CONTENT -->

                                    <div class="bn-recent-content">

                                        <span class="bn-recent-date">

                                            <i class="fa fa-calendar"></i>

                                            @if(!empty($recent->date))

                                                {{ \Carbon\Carbon::parse($recent->date)->format('M d, Y') }}

                                            @elseif(!empty($recent->created_at))

                                                {{ \Carbon\Carbon::parse($recent->created_at)->format('M d, Y') }}

                                            @endif

                                        </span>


                                        <h4>
                                            {{ \Illuminate\Support\Str::limit($recent->title, 55) }}
                                        </h4>


                                        <span class="bn-read-article">
                                            Read Article
                                            <i class="fa fa-angle-right"></i>
                                        </span>

                                    </div>

                                </a>

                            @empty

                                <div class="bn-no-recent-news">

                                    <div>
                                        <i class="fa fa-newspaper-o"></i>
                                    </div>

                                    <p>
                                        No recent news available.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>



                    <!-- SIDEBAR BOOKING CARD -->

                    <div class="bn-sidebar-booking">

                        <div class="bn-sidebar-booking-icon">
                            <i class="fa fa-taxi"></i>
                        </div>

                        <span>
                            NEED A RIDE?
                        </span>

                        <h3>
                            Book Your Taxi Today
                        </h3>

                        <p>
                            Professional Brighton taxi service
                            available 24 hours a day.
                        </p>

                        <a href="{{ url('/book-now') }}">
                            Book a Taxi
                            <i class="fa fa-arrow-right"></i>
                        </a>

                    </div>


                </aside>

            </div>

        </div>

    </div>

</section>
        
        @include('goods.include.footer')
    </body>
</html>