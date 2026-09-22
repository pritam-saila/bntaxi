<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $blog->title }}</title>
        <meta name="keywords" content="{{ $blog->metatag ?? '' }}">
        <meta name="description" content="{{ $blog->metadescription ?? '' }}">

        @include('goods.include.assets')
        
        <style>
            /* =========================================================
   BN TAXI - NEWS DETAILS PAGE
========================================================= */


/* =========================================
   HERO
========================================= */

.bn-news-details-hero {
    position: relative;

    min-height: 330px;

    display: flex;

    align-items: center;

    overflow: hidden;

    background:
        linear-gradient(
            120deg,
            rgba(4,22,42,0.98),
            rgba(7,55,75,0.92)
        );
}


.bn-news-details-hero::before {
    content: "";

    position: absolute;

    width: 450px;
    height: 450px;

    right: -230px;
    top: -300px;

    border: 65px solid rgba(37,99,235,0.08);

    border-radius: 50%;
}


.bn-news-details-hero::after {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    left: -190px;
    bottom: -230px;

    border: 45px solid rgba(37,99,235,0.08);

    border-radius: 50%;
}


.bn-news-details-overlay {
    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            135deg,
            transparent 45%,
            rgba(37,99,235,0.05)
        );
}


.bn-news-details-hero-content {
    position: relative;

    z-index: 2;

    padding: 55px 0;
}


.bn-details-badge {
    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 8px 15px;

    border-radius: 50px;

    border: 1px solid rgba(37,99,235,0.28);

    background: rgba(37,99,235,0.11);

    color: #fff;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: 1.5px;

    text-transform: uppercase;
}


.bn-news-details-hero h1 {
    margin: 18px 0 13px;

    color: #fff;

    font-size: clamp(40px, 5vw, 60px);

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -1px;
}


.bn-breadcrumb {
    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 9px;

    color: rgba(255,255,255,0.55);

    font-size: 13px;
}


.bn-breadcrumb a {
    color: rgba(255,255,255,0.72);

    text-decoration: none;

    transition: color .25s ease;
}


.bn-breadcrumb a:hover {
    color: #2563EB;
}


.bn-breadcrumb i {
    color: #2563EB;

    font-size: 9px;
}


.bn-breadcrumb span {
    color: #fff;
}


/* =========================================
   MAIN SECTION
========================================= */

.bn-news-details-section {
    position: relative;

    padding: 75px 0 90px;

    background: #F7F9FC;
}


.bn-news-details-section::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 4px;

    background:
        linear-gradient(
            90deg,
            #2563EB 0%,
            #2563EB 35%,
            #2563EB 35%,
            #2563EB 65%,
            #2563EB 65%,
            #2563EB 100%
        );
}


/* =========================================
   ARTICLE
========================================= */

.bn-news-article {
    overflow: hidden;

    background: #fff;

    border: 1px solid #e6ebf0;

    border-radius: 20px;

    box-shadow:
        0 12px 40px rgba(6,30,50,0.08);
}


/* =========================================
   FEATURED IMAGE
========================================= */

.bn-news-featured-image {
    position: relative;

    width: 100%;

    height: 460px;

    overflow: hidden;

    background:
        linear-gradient(
            135deg,
            #123B8F,
            #2563EB
        );
}


.bn-news-featured-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition: transform .6s ease;
}


.bn-news-article:hover
.bn-news-featured-image img {
    transform: scale(1.025);
}


.bn-featured-badge {
    position: absolute;

    left: 22px;
    bottom: 22px;

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 9px 14px;

    border-radius: 50px;

    background: #fff;

    color: #123B8F;

    font-size: 11px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .7px;

    box-shadow:
        0 7px 20px rgba(0,0,0,0.18);
}


.bn-news-no-image {
    width: 100%;
    height: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #2563EB;

    font-size: 65px;
}


/* =========================================
   ARTICLE CONTENT
========================================= */

.bn-news-article-content {
    padding: 35px 38px 38px;
}


/* =========================================
   META
========================================= */

.bn-news-meta {
    display: flex;

    align-items: center;

    flex-wrap: wrap;

    gap: 12px;

    margin-bottom: 18px;

    color: #7e8b98;

    font-size: 12px;

    font-weight: 600;
}


.bn-news-meta i {
    margin-right: 5px;

    color: #1D4ED8;
}


.bn-meta-separator {
    width: 4px;
    height: 4px;

    border-radius: 50%;

    background: #c4ccd4;
}


/* =========================================
   TITLE
========================================= */

.bn-news-article-title {
    margin: 0;

    color: #123B8F;

    font-size: clamp(28px, 3vw, 40px);

    line-height: 1.2;

    font-weight: 800;

    letter-spacing: -.5px;
}


.bn-article-title-line {
    width: 70px;

    height: 4px;

    margin: 19px 0 27px;

    border-radius: 10px;

    background:
        linear-gradient(
            90deg,
            #2563EB,
            #2563EB
        );
}


.bn-article-title-line span {
    display: block;

    width: 22px;
    height: 4px;

    border-radius: 10px;

    background: #123B8F;
}


/* =========================================
   BLOG DESCRIPTION
========================================= */

.bn-blog-description {
    color: #566575;

    font-size: 15px;

    line-height: 1.9;
}


/* Admin HTML content */

.bn-blog-description p {
    margin-bottom: 18px;
}


.bn-blog-description h2,
.bn-blog-description h3,
.bn-blog-description h4 {
    margin-top: 30px;
    margin-bottom: 14px;

    color: #123B8F;

    font-weight: 750;
}


.bn-blog-description h2 {
    font-size: 28px;
}


.bn-blog-description h3 {
    font-size: 23px;
}


.bn-blog-description h4 {
    font-size: 19px;
}


.bn-blog-description ul,
.bn-blog-description ol {
    margin: 18px 0;

    padding-left: 25px;
}


.bn-blog-description li {
    margin-bottom: 8px;
}


.bn-blog-description a {
    color: #2563EB;

    font-weight: 600;

    text-decoration: underline;
}


.bn-blog-description img {
    max-width: 100%;

    height: auto;

    border-radius: 12px;

    margin: 15px 0;
}


.bn-blog-description blockquote {
    margin: 25px 0;

    padding: 20px 25px;

    border-left: 4px solid #2563EB;

    border-radius: 0 10px 10px 0;

    background: #EEF4FF;

    color: #43566a;

    font-style: italic;
}


/* =========================================
   ARTICLE FOOTER
========================================= */

.bn-article-footer {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin-top: 35px;

    padding-top: 23px;

    border-top: 1px solid #e8edf1;
}


.bn-article-share-text {
    display: flex;

    align-items: center;

    gap: 9px;

    color: #7b8995;

    font-size: 12px;

    font-weight: 600;
}


.bn-article-share-text i {
    color: #1D4ED8;
}


.bn-back-news {
    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 10px 15px;

    border-radius: 8px;

    background: #EAF1FF;

    color: #1D4ED8;

    font-size: 12px;

    font-weight: 800;

    text-decoration: none;

    transition: all .25s ease;
}


.bn-back-news:hover {
    background: #2563EB;

    color: #123B8F;

    transform: translateX(-3px);
}


/* =========================================
   BOOKING CTA
========================================= */

.bn-news-booking-cta {
    display: flex;

    align-items: center;

    gap: 18px;

    margin-top: 25px;

    padding: 22px 24px;

    border-radius: 17px;

    background:
        linear-gradient(
            105deg,
            #123B8F,
            #2563EB
        );

    box-shadow:
        0 12px 35px rgba(6,30,50,0.13);
}


.bn-booking-cta-icon {
    width: 52px;
    height: 52px;

    flex: 0 0 52px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 14px;

    background: #2563EB;

    color: #fff;

    font-size: 20px;
}


.bn-booking-cta-content {
    flex: 1;
}


.bn-booking-cta-content > span {
    color: #2563EB;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: 1.5px;
}


.bn-booking-cta-content h3 {
    margin: 3px 0 4px;

    color: #fff;

    font-size: 18px;

    font-weight: 750;
}


.bn-booking-cta-content p {
    margin: 0;

    color: rgba(255,255,255,0.62);

    font-size: 11px;

    line-height: 1.6;
}


.bn-booking-cta-button {
    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 12px 17px;

    border-radius: 9px;

    background: #fff;

    color: #123B8F;

    font-size: 12px;

    font-weight: 800;

    text-decoration: none;

    white-space: nowrap;

    transition: all .25s ease;
}


.bn-booking-cta-button:hover {
    background: #fff;

    color: #123B8F;

    transform: translateY(-2px);
}


/* =========================================
   SIDEBAR
========================================= */

.bn-news-sidebar {
    position: sticky;

    top: 25px;
}


/* =========================================
   SIDEBAR WIDGET
========================================= */

.bn-sidebar-widget {
    overflow: hidden;

    background: #fff;

    border: 1px solid #e6ebf0;

    border-radius: 18px;

    box-shadow:
        0 10px 35px rgba(6,30,50,0.07);
}


.bn-sidebar-heading {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 22px 22px 19px;

    border-bottom: 1px solid #e9edf1;
}


.bn-sidebar-small-title {
    display: block;

    margin-bottom: 4px;

    color: #1D4ED8;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: 1.3px;
}


.bn-sidebar-heading h3 {
    margin: 0;

    color: #123B8F;

    font-size: 21px;

    font-weight: 800;
}


.bn-sidebar-heading-icon {
    width: 39px;
    height: 39px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #EAF1FF;

    color: #1D4ED8;

    font-size: 14px;
}


/* =========================================
   RECENT NEWS
========================================= */

.bn-recent-news-list {
    padding: 8px 20px 15px;
}


.bn-recent-news {
    display: flex;

    gap: 13px;

    padding: 14px 0;

    border-bottom: 1px dashed #e0e6eb;

    text-decoration: none;

    transition: transform .25s ease;
}


.bn-recent-news:last-child {
    border-bottom: none;
}


.bn-recent-news:hover {
    transform: translateX(4px);
}


.bn-recent-image {
    position: relative;

    width: 82px;
    height: 82px;

    flex: 0 0 82px;

    overflow: hidden;

    border-radius: 10px;

    background:
        linear-gradient(
            135deg,
            #123B8F,
            #2563EB
        );
}


.bn-recent-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition: transform .4s ease;
}


.bn-recent-news:hover
.bn-recent-image img {
    transform: scale(1.08);
}


.bn-recent-no-image {
    width: 100%;
    height: 100%;

    display: flex;

    align-items: center;
    justify-content: center;

    color: #2563EB;

    font-size: 25px;
}


.bn-recent-content {
    min-width: 0;

    padding-top: 2px;
}


.bn-recent-date {
    display: block;

    margin-bottom: 5px;

    color: #8b97a2;

    font-size: 9px;

    font-weight: 600;
}


.bn-recent-date i {
    margin-right: 4px;

    color: #1D4ED8;
}


.bn-recent-content h4 {
    margin: 0 0 7px;

    color: #173a55;

    font-size: 12.5px;

    line-height: 1.45;

    font-weight: 700;

    transition: color .25s ease;
}


.bn-recent-news:hover
.bn-recent-content h4 {
    color: #1D4ED8;
}


.bn-read-article {
    display: inline-flex;

    align-items: center;

    gap: 5px;

    color: #2563EB;

    font-size: 9px;

    font-weight: 800;
}


.bn-read-article i {
    transition: transform .25s ease;
}


.bn-recent-news:hover
.bn-read-article i {
    transform: translateX(3px);
}


/* =========================================
   NO RECENT NEWS
========================================= */

.bn-no-recent-news {
    padding: 30px 10px;

    text-align: center;
}


.bn-no-recent-news > div {
    width: 55px;
    height: 55px;

    margin: 0 auto 12px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #EAF1FF;

    color: #1D4ED8;

    font-size: 21px;
}


.bn-no-recent-news p {
    margin: 0;

    color: #8b96a0;

    font-size: 12px;
}


/* =========================================
   SIDEBAR BOOKING
========================================= */

.bn-sidebar-booking {
    position: relative;

    overflow: hidden;

    margin-top: 22px;

    padding: 28px 24px;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #123B8F,
            #2563EB
        );

    box-shadow:
        0 12px 35px rgba(6,30,50,0.13);
}


.bn-sidebar-booking::after {
    content: "";

    position: absolute;

    width: 150px;
    height: 150px;

    right: -80px;
    top: -70px;

    border: 25px solid rgba(37,99,235,0.09);

    border-radius: 50%;
}


.bn-sidebar-booking-icon {
    width: 48px;
    height: 48px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-bottom: 18px;

    border-radius: 13px;

    background: #2563EB;

    color: #123B8F;

    font-size: 19px;
}


.bn-sidebar-booking > span {
    color: #fff;

    font-size: 9px;

    font-weight: 800;

    letter-spacing: 1.5px;
}


.bn-sidebar-booking h3 {
    position: relative;

    z-index: 2;

    margin: 5px 0 8px;

    color: #fff;

    font-size: 22px;

    line-height: 1.2;

    font-weight: 800;
}


.bn-sidebar-booking p {
    position: relative;

    z-index: 2;

    margin: 0 0 18px;

    color: rgba(255,255,255,0.62);

    font-size: 12px;

    line-height: 1.7;
}


.bn-sidebar-booking > a {
    position: relative;

    z-index: 2;

    display: inline-flex;

    align-items: center;

    gap: 9px;

    padding: 11px 16px;

    border-radius: 8px;

    background: #fff;

    color: #123B8F;

    font-size: 11px;

    font-weight: 800;

    text-decoration: none;

    transition: all .25s ease;
}


.bn-sidebar-booking > a:hover {
    background: #fff;

    color: #123B8F;

    transform: translateY(-2px);
}


/* =========================================
   TABLET
========================================= */

@media (max-width: 991px) {

    .bn-news-details-section {
        padding: 60px 0 70px;
    }


    .bn-news-sidebar {
        position: static;
    }


    .bn-news-featured-image {
        height: 400px;
    }


    .bn-news-booking-cta {
        margin-bottom: 10px;
    }

}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767px) {

    .bn-news-details-hero {
        min-height: 270px;
    }


    .bn-news-details-hero-content {
        padding: 45px 0;
    }


    .bn-news-details-hero h1 {
        font-size: 38px;
    }


    .bn-news-details-section {
        padding: 45px 0 60px;
    }


    .bn-news-featured-image {
        height: 270px;
    }


    .bn-news-article {
        border-radius: 15px;
    }


    .bn-news-article-content {
        padding: 25px 20px 25px;
    }


    .bn-news-article-title {
        font-size: 27px;
    }


    .bn-blog-description {
        font-size: 14px;

        line-height: 1.8;
    }


    .bn-article-footer {
        align-items: flex-start;

        flex-direction: column;

        gap: 15px;
    }


    .bn-news-booking-cta {
        align-items: flex-start;

        flex-wrap: wrap;

        padding: 20px;

        border-radius: 15px;
    }


    .bn-booking-cta-content {
        min-width: calc(100% - 72px);
    }


    .bn-booking-cta-button {
        width: 100%;

        justify-content: center;
    }


    .bn-sidebar-widget {
        border-radius: 15px;
    }


    .bn-sidebar-booking {
        border-radius: 15px;
    }

}


/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .bn-news-details-hero {
        min-height: 245px;
    }


    .bn-details-badge {
        font-size: 9px;

        padding: 7px 12px;
    }


    .bn-news-details-hero h1 {
        font-size: 34px;
    }


    .bn-breadcrumb {
        font-size: 11px;
    }


    .bn-news-featured-image {
        height: 220px;
    }


    .bn-featured-badge {
        left: 15px;
        bottom: 15px;

        font-size: 9px;

        padding: 7px 11px;
    }


    .bn-news-meta {
        font-size: 10px;
    }


    .bn-news-article-title {
        font-size: 24px;
    }


    .bn-news-article-content {
        padding: 22px 17px;
    }


    .bn-recent-news-list {
        padding-left: 15px;
        padding-right: 15px;
    }


    .bn-recent-image {
        width: 72px;
        height: 72px;

        flex-basis: 72px;
    }


    .bn-recent-content h4 {
        font-size: 12px;
    }


    .bn-sidebar-booking {
        padding: 23px 20px;
    }

}
        </style>
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