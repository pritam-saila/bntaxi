<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')
        
        
        <style>
            /* =========================================
   BN TAXI NEWS PAGE
========================================= */

.bn-news-hero {
    position: relative;
    min-height: 280px;
    display: flex;
    align-items: center;
    overflow: hidden;

    background:
        linear-gradient(
            110deg,
            rgba(7, 18, 40, 0.97) 0%,
            rgba(8, 35, 67, 0.90) 48%,
            rgba(37, 99, 235, 0.78) 100%
        ),
        url('/images/taxi-banner.jpg') center/cover no-repeat;
}

.bn-news-hero::before {
    content: "";
    position: absolute;
    width: 420px;
    height: 420px;
    border-radius: 50%;
    right: -130px;
    top: -170px;
    background: rgba(37, 99, 235, 0.13);
}

.bn-news-hero::after {
    content: "";
    position: absolute;
    width: 280px;
    height: 280px;
    border-radius: 50%;
    left: -150px;
    bottom: -170px;
    background: rgba(37, 99, 235, 0.12);
}

.bn-news-hero-overlay {
    position: absolute;
    inset: 0;
    background:
        linear-gradient(
            135deg,
            transparent 40%,
            rgba(37, 99, 235, 0.08)
        );
}

.bn-news-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 40px;
    padding-bottom: 40px;
}

.bn-news-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 9px 16px;

    border-radius: 50px;

    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.20);

    color: #fff;

    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;

    backdrop-filter: blur(8px);
}

.bn-news-hero h1 {
    margin: 20px 0 10px;
    color: #fff;
    font-size: 32px;
    line-height: 1.05;
    font-weight: 800;
    letter-spacing: -1.5px;
}

.bn-news-hero p {
    margin: 0;

    color: rgba(255,255,255,0.82);

    font-size: 18px;
    font-weight: 400;
}


/* =========================================
   BLOG SECTION
========================================= */

.bn-blog-section {
    position: relative;

    padding: 90px 0 100px;

    background: #f7f9fc;
}


/* Decorative top shape */

.bn-blog-section::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 5px;

    background:
        linear-gradient(
            90deg,
            #2563eb 0%,
            #2563eb 35%,
            #123b8f 35%,
            #123b8f 100%
        );
}


/* =========================================
   SECTION HEADING
========================================= */

.bn-section-heading {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;

    gap: 40px;

    margin-bottom: 45px;
}

.bn-small-title {
    display: block;

    margin-bottom: 8px;

    color: #1d4ed8;

    font-size: 13px;
    font-weight: 800;

    letter-spacing: 2px;
}

.bn-section-heading h2 {
    margin: 0;

    color: #123b8f;

    font-size: clamp(32px, 4vw, 46px);
    line-height: 1.1;

    font-weight: 700;
}

.bn-section-heading h2 strong {
    color: #1d4ed8;
}

.bn-section-heading > p {
    max-width: 480px;

    margin: 0;

    color: #697586;

    font-size: 15px;
    line-height: 1.8;
}


/* =========================================
   BLOG GRID
========================================= */

.bn-blog-grid {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 28px;
}


/* =========================================
   BLOG CARD
========================================= */

.bn-blog-card {
    position: relative;

    overflow: hidden;

    background: #fff;

    border-radius: 18px;

    border: 1px solid #e7ebf0;

    box-shadow:
        0 8px 30px rgba(9, 35, 63, 0.07);

    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease,
        border-color 0.35s ease;
}

.bn-blog-card:hover {
    transform: translateY(-8px);

    border-color: rgba(37,99,235,0.35);

    box-shadow:
        0 18px 45px rgba(9, 35, 63, 0.14);
}


/* =========================================
   IMAGE
========================================= */

.bn-blog-image {
    position: relative;

    display: block;

    height: 245px;

    overflow: hidden;

    background: #e9eef3;
}

.bn-blog-image img {
    width: 100%;
    height: 100%;

    display: block;

    object-fit: cover;

    transition:
        transform 0.55s ease;
}

.bn-blog-card:hover .bn-blog-image img {
    transform: scale(1.07);
}


/* Image dark overlay */

.bn-blog-image::after {
    content: "";

    position: absolute;

    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(4,20,38,0.55),
            transparent 55%
        );

    pointer-events: none;
}


/* Category */

.bn-blog-category {
    position: absolute;

    z-index: 3;

    top: 18px;
    left: 18px;

    padding: 7px 12px;

    border-radius: 30px;

    background: #2563eb;

    color: #fff;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: .6px;

    text-transform: uppercase;

    box-shadow:
        0 5px 15px rgba(0,0,0,0.15);
}


/* Arrow */

.bn-image-arrow {
    position: absolute;

    z-index: 3;

    right: 18px;
    bottom: 18px;

    width: 42px;
    height: 42px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: rgba(255,255,255,0.94);

    color: #123b8f;

    font-size: 14px;

    opacity: 0;

    transform: translateY(10px);

    transition:
        all 0.3s ease;
}

.bn-blog-card:hover .bn-image-arrow {
    opacity: 1;

    transform: translateY(0);
}


/* =========================================
   CONTENT
========================================= */

.bn-blog-content {
    padding: 25px 25px 24px;
}


/* Meta */

.bn-blog-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 9px;

    margin-bottom: 13px;

    color: #8491a1;

    font-size: 12px;
    font-weight: 600;
}

.bn-blog-meta i {
    margin-right: 4px;

    color: #1d4ed8;
}

.bn-meta-dot {
    width: 4px;
    height: 4px;

    border-radius: 50%;

    background: #c6ccd3;
}


/* Title */

.bn-blog-content h3 {
    margin: 0 0 12px;

    font-size: 21px;

    line-height: 1.35;

    font-weight: 750;
}

.bn-blog-content h3 a {
    color: #123b8f;

    text-decoration: none;

    transition: color 0.25s ease;
}

.bn-blog-content h3 a:hover {
    color: #1e40af;
}


/* Description */

.bn-blog-content > p {
    margin: 0 0 20px;

    color: #697586;

    font-size: 14px;

    line-height: 1.75;
}


/* Footer */

.bn-card-footer {
    padding-top: 17px;

    border-top: 1px solid #edf0f3;
}


/* Read more */

.bn-readmore {
    display: inline-flex;

    align-items: center;

    gap: 10px;

    color: #123b8f;

    font-size: 13px;

    font-weight: 800;

    text-decoration: none;

    transition: color 0.25s ease;
}

.bn-readmore span {
    width: 30px;
    height: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #2563eb;

    color: #fff;

    transition:
        transform 0.25s ease;
}

.bn-readmore:hover {
    color: #1e40af;
}

.bn-readmore:hover span {
    transform: translateX(5px);
}


/* =========================================
   NO IMAGE
========================================= */

.bn-no-image {
    width: 100%;
    height: 100%;

    display: flex;
    align-items: center;
    justify-content: center;

    background:
        linear-gradient(
            135deg,
            #123b8f,
            #1d4ed8
        );

    color: #2563eb;

    font-size: 50px;
}


/* =========================================
   EMPTY STATE
========================================= */

.bn-empty-news {
    max-width: 650px;

    margin: 20px auto 0;

    padding: 60px 30px;

    text-align: center;

    background: #fff;

    border-radius: 18px;

    border: 1px solid #e7ebf0;

    box-shadow:
        0 10px 35px rgba(9,35,63,0.07);
}

.bn-empty-icon {
    width: 75px;
    height: 75px;

    margin: 0 auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #eaf1ff;

    color: #1d4ed8;

    font-size: 30px;
}

.bn-empty-news h3 {
    margin: 0 0 8px;

    color: #123b8f;

    font-size: 24px;
}

.bn-empty-news p {
    margin: 0;

    color: #7a8795;

    font-size: 14px;
}


/* =========================================
   TABLET
========================================= */

@media (max-width: 991px) {

    .bn-news-hero {
        min-height: 330px;
    }

    .bn-blog-section {
        padding: 70px 0 80px;
    }

    .bn-section-heading {
        align-items: flex-start;
        flex-direction: column;

        gap: 15px;

        margin-bottom: 35px;
    }

    .bn-section-heading > p {
        max-width: 650px;
    }

    .bn-blog-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 24px;
    }

    .bn-blog-image {
        height: 220px;
    }
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 767px) {

    .bn-news-hero {
        min-height: 290px;
    }

    .bn-news-hero-content {
        padding-top: 35px;
        padding-bottom: 35px;
    }

    .bn-news-badge {
        font-size: 11px;

        padding: 8px 13px;
    }

    .bn-news-hero h1 {
        margin-top: 16px;

        font-size: 42px;

        letter-spacing: -1px;
    }

    .bn-news-hero p {
        font-size: 15px;

        line-height: 1.6;
    }


    .bn-blog-section {
        padding: 55px 0 65px;
    }

    .bn-section-heading {
        margin-bottom: 30px;
    }

    .bn-section-heading h2 {
        font-size: 34px;
    }

    .bn-section-heading > p {
        font-size: 14px;

        line-height: 1.7;
    }


    .bn-blog-grid {
        grid-template-columns: 1fr;

        gap: 22px;
    }


    .bn-blog-image {
        height: 230px;
    }


    .bn-blog-content {
        padding: 22px 20px 21px;
    }


    .bn-blog-content h3 {
        font-size: 20px;
    }


    .bn-blog-content > p {
        font-size: 14px;
    }
}


/* =========================================
   SMALL MOBILE
========================================= */

@media (max-width: 480px) {

    .bn-news-hero {
        min-height: 260px;
    }

    .bn-news-hero h1 {
        font-size: 36px;
    }

    .bn-news-hero p {
        font-size: 14px;
    }

    .bn-blog-section {
        padding-top: 45px;
    }

    .bn-blog-image {
        height: 210px;
    }

    .bn-blog-content {
        padding: 20px 18px;
    }

    .bn-blog-content h3 {
        font-size: 19px;
    }

    .bn-blog-meta {
        font-size: 11px;
    }
}
        </style>
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
       <section class="bn-news-hero">
    <div class="bn-news-hero-overlay"></div>

    <div class="container bn-news-hero-content">
        <span class="bn-news-badge">
            <i class="fas fa-newspaper"></i> BN Taxi News
        </span>

        <h1>News & Updates</h1>

        <p>
            Reliable & Professional Brighton Taxi Service
        </p>
    </div>
</section>


<section class="bn-blog-section">
    <div class="container">

        <div class="bn-section-heading">
            <div>
                <span class="bn-small-title">LATEST NEWS</span>
                <h2>From <strong>BN Taxi</strong></h2>
            </div>

            <p>
                Stay updated with the latest news, travel tips,
                taxi information and updates from BN Taxi.
            </p>
        </div>


        @if($blogs->count())

        <div class="bn-blog-grid">

            @foreach($blogs as $blog)

            <article class="bn-blog-card">

                {{-- Blog Image --}}
                <a href="{{ url('/news/'.$blog->slug) }}" class="bn-blog-image">

                    @if(!empty($blog->image))
                        <img
                            src="{{ url(Storage::url($blog->image)) }}"
                            alt="{{ $blog->title }}"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('images/default-blog.jpg') }}';"
                        >
                    @else
                        <div class="bn-no-image">
                            <i class="fas fa-taxi"></i>
                        </div>
                    @endif

                    <span class="bn-blog-category">
                        BN Taxi
                    </span>

                    <span class="bn-image-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </span>

                </a>


                {{-- Blog Content --}}
                <div class="bn-blog-content">

                    <div class="bn-blog-meta">

                        <span>
                            <i class="far fa-calendar-alt"></i>

                            @if(!empty($blog->date))
                                {{ \Carbon\Carbon::parse($blog->date)->format('M d, Y') }}
                            @else
                                {{ $blog->created_at ? $blog->created_at->format('M d, Y') : '' }}
                            @endif
                        </span>

                        <span class="bn-meta-dot"></span>

                        <span>
                            <i class="fas fa-taxi"></i>
                            BN Taxi
                        </span>

                    </div>


                    <h3>
                        <a href="{{ url('/news/'.$blog->slug) }}">
                            {{ $blog->title }}
                        </a>
                    </h3>


                    <p>
                        {!! \Illuminate\Support\Str::limit(
                            strip_tags($blog->description ?? ''),
                            145
                        ) !!}
                    </p>


                    <div class="bn-card-footer">

                        <a
                            href="{{ url('/news/'.$blog->slug) }}"
                            class="bn-readmore"
                        >
                            Read Article
                            <span>
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </a>

                    </div>

                </div>

            </article>

            @endforeach

        </div>

        @else

        <div class="bn-empty-news">

            <div class="bn-empty-icon">
                <i class="far fa-newspaper"></i>
            </div>

            <h3>No News Available</h3>

            <p>
                There are no news articles available at the moment.
                Please check back soon.
            </p>

        </div>

        @endif

    </div>
</section>
        @include('goods.include.footer')
    </body>
</html>