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


        <style>
            /* Hero slider (no library) */
.bn-hero{position:relative;width:100%;overflow:hidden;background:#06122b;touch-action:pan-y}
.bn-hero-track{display:flex;transition:transform .8s ease;will-change:transform}
.bn-hero-slide{flex:0 0 100%;min-width:100%;position:relative}
.bn-hero img{width:100%;height:auto;aspect-ratio:1600/667;display:block;object-fit:cover}
.bn-hero-btn{position:absolute;top:50%;transform:translateY(-50%);z-index:3;width:44px;height:44px;border:0;border-radius:50%;
    background:rgba(0,0,0,.35);color:#fff;font-size:26px;line-height:44px;text-align:center;cursor:pointer;padding:0}
.bn-hero-btn:hover,.bn-hero-btn:focus-visible{background:rgba(0,0,0,.6)}
.bn-hero-prev{left:12px}.bn-hero-next{right:12px}
.bn-hero-dots{position:absolute;left:0;right:0;bottom:6px;z-index:3;display:flex;justify-content:center;gap:4px}
.bn-hero-dots button{width:24px;height:24px;padding:0;border:0;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center}
.bn-hero-dots button::before{content:"";width:12px;height:12px;border-radius:50%;background:#fff;opacity:.6;transition:.2s}
.bn-hero-dots button[aria-current="true"]::before{opacity:1;background:#ff6600}
@media (prefers-reduced-motion:reduce){.bn-hero-track{transition:none}}
@media (max-width:768px){.bn-hero-btn{display:none}.bn-hero-dots{bottom:2px}}

.banner-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.45);
}

.banner-content {
    position: absolute;
    top: 50%;
    left: 8%;
    transform: translateY(-50%);
    z-index: 5;
    color: #fff;
    max-width: 600px;
}

.banner-content h1{
    font-size:52px;
    font-weight:700;
    margin-bottom:20px;
}

.banner-content p{
    font-size:18px;
    line-height:30px;
}

.banner-content .btn{
    margin-top:20px;
    padding:12px 35px;
    border-radius:50px;
}

@media(max-width:768px){

.banner-content{
    left:20px;
    right:20px;
}

.banner-content h1{
    font-size:28px;
}

.banner-content p{
    font-size:14px;
    line-height:22px;
}

}


/* =========================================================
   BN TAXI - AIRPORT TRANSFERS
   PREMIUM HEAVY ROYAL BLUE + WHITE
   ========================================================= */

.airport-section {
    position: relative;
    overflow: hidden;

    padding: 70px 15px 80px;

    background:
        radial-gradient(
            circle at 92% 12%,
            rgba(21, 87, 214, 0.10),
            transparent 230px
        ),
        radial-gradient(
            circle at 5% 90%,
            rgba(21, 87, 214, 0.07),
            transparent 220px
        ),
        linear-gradient(
            135deg,
            #eaf3ff 0%,
            #f8fbff 48%,
            #e9f3ff 100%
        );
}


/* Decorative circle */

.airport-section::before {
    content: "";

    position: absolute;

    width: 430px;
    height: 430px;

    right: -250px;
    top: -250px;

    border: 65px solid rgba(21, 87, 214, 0.06);

    border-radius: 50%;

    pointer-events: none;
}


/* =========================================================
   TITLE
   ========================================================= */

.airport-title {
    position: relative;

    z-index: 2;

    text-align: center;

    margin-bottom: 42px;
}


.airport-title h2 {
    display: inline-block;

    position: relative;

    margin: 0;

    padding: 0 0 14px;

    color: #082f7d;

    font-size: clamp(25px, 3vw, 36px);

    line-height: 1.2;

    font-weight: 850;

    letter-spacing: -.5px;
}


/* Blue underline */

.airport-title h2::after {
    content: "";

    position: absolute;

    left: 50%;

    bottom: 0;

    transform: translateX(-50%);

    width: 75px;
    height: 4px;

    border-radius: 20px;

    background:
        linear-gradient(
            90deg,
            #082f7d,
            #1557d6
        );
}


/* =========================================================
   MAIN WRAPPER
   ========================================================= */

.airport-wrapper {
    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        minmax(0, 1fr);

    gap: 28px;

    max-width: 1120px;

    margin: 0 auto;
}


/* =========================================================
   COMMON CARD
   ========================================================= */

.airport-left,
.airport-right {
    position: relative;

    overflow: hidden;

    background: #ffffff;

    border:
        1px solid rgba(21, 87, 214, .13);

    border-radius: 22px;

    box-shadow:
        0 22px 55px rgba(8, 47, 125, .13),
        0 5px 18px rgba(8, 47, 125, .06);

    transition:
        transform .25s ease,
        box-shadow .25s ease;
}


.airport-left:hover,
.airport-right:hover {
    transform: translateY(-3px);

    box-shadow:
        0 28px 65px rgba(8, 47, 125, .17),
        0 7px 22px rgba(8, 47, 125, .07);
}


/* Top blue border */

.airport-left::before,
.airport-right::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 5px;

    background:
        linear-gradient(
            90deg,
            #082f7d,
            #1557d6,
            #082f7d
        );
}


/* =========================================================
   LEFT CARD
   ========================================================= */

.airport-left {
    padding: 30px;
}


.airport-left ul {
    margin: 0;

    padding: 0;

    list-style: none;
}


/* Airport rows */

.airport-left li {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    min-height: 54px;

    padding: 8px 0;

    border-bottom:
        1px solid #e3ebf6;
}


.airport-left li:last-child {
    border-bottom: 0;
}


/* Airport name */

.airport-left li strong {
    color: #13294b;

    font-size: 14px;

    line-height: 1.4;

    font-weight: 800;
}


/* Price */

.airport-left li span {
    flex-shrink: 0;

    padding: 7px 11px;

    border-radius: 7px;

    background: #edf5ff;

    border:
        1px solid #d7e7fb;

    color: #1557d6;

    font-size: 14px;

    line-height: 1;

    font-weight: 850;

    white-space: nowrap;
}


/* =========================================================
   NOTE
   ========================================================= */

.airport-left .note {
    margin: 20px 0 18px;

    padding: 12px 14px;

    background: #f4f8ff;

    border-left:
        3px solid #1557d6;

    border-radius: 7px;

    color: #4d5b70;

    font-size: 14px;

    line-height: 1.6;
}


/* =========================================================
   CALL BUTTON
   ========================================================= */

.airport-left .btn-call {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 46px;

    padding: 11px 24px;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #1557d6,
            #0b3d9e
        );

    color: #ffffff;

    font-size: 12px;

    font-weight: 850;

    text-decoration: none;

    box-shadow:
        0 9px 20px rgba(21, 87, 214, .23);

    transition:
        transform .2s ease,
        box-shadow .2s ease,
        background .2s ease;
}


.airport-left .btn-call:hover {
    background:
        linear-gradient(
            135deg,
            #0b3d9e,
            #082f7d
        );

    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 27px rgba(21, 87, 214, .28);
}


/* =========================================================
   RIGHT CARD
   ========================================================= */

.airport-right {
    padding: 32px;
}


/* Right card decorative blue shape */

.airport-right::after {
    content: "";

    position: absolute;

    width: 190px;
    height: 190px;

    right: -115px;
    bottom: -115px;

    border:
        30px solid rgba(21, 87, 214, .055);

    border-radius: 50%;

    pointer-events: none;
}


/* Paragraph */

.airport-right p {
    position: relative;

    z-index: 2;

    margin: 0 0 20px;

    color: #4f6078;

    font-size: 16px;

    line-height: 1.85;

    font-weight: 500;
}


.airport-right p:last-of-type {
    margin-bottom: 25px;
}


/* Highlight first paragraph */

.airport-right p:first-child {
    color: #253d60;

    font-weight: 550;
}


/* =========================================================
   BOOK BUTTON
   ========================================================= */

.airport-right .btn-book {
    position: relative;

    z-index: 3;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-height: 46px;

    padding: 11px 25px;

    border-radius: 9px;

    background:
        linear-gradient(
            135deg,
            #1557d6,
            #0b3d9e
        );

    color: #ffffff;

    font-size: 12px;

    font-weight: 850;

    text-decoration: none;

    box-shadow:
        0 9px 21px rgba(21, 87, 214, .23);

    transition:
        transform .2s ease,
        box-shadow .2s ease;
}


.airport-right .btn-book:hover {
    color: #ffffff;

    transform: translateY(-2px);

    box-shadow:
        0 13px 28px rgba(21, 87, 214, .28);

    background:
        linear-gradient(
            135deg,
            #0b3d9e,
            #082f7d
        );
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 991px) {

    .airport-section {
        padding: 55px 15px 65px;
    }

    .airport-wrapper {
        grid-template-columns: 1fr;

        max-width: 760px;

        gap: 20px;
    }

    .airport-left,
    .airport-right {
        border-radius: 20px;
    }
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767px) {

    .airport-section {
        padding: 40px 10px 50px;
    }

    .airport-title {
        margin-bottom: 27px;
    }

    .airport-title h2 {
        font-size: 24px;

        line-height: 1.3;
    }

    .airport-wrapper {
        gap: 16px;
    }

    .airport-left {
        padding: 22px 17px;
    }

    .airport-right {
        padding: 23px 18px;
    }

    .airport-left li {
        min-height: 51px;

        gap: 10px;
    }

    .airport-left li strong {
        font-size: 12px;
    }

    .airport-left li span {
        padding: 6px 8px;

        font-size: 10px;
    }

    .airport-left .note {
        font-size: 13px;

        margin-top: 17px;
    }

    .airport-right p {
        font-size: 15px;

        line-height: 1.75;

        margin-bottom: 17px;
    }

    .airport-left .btn-call,
    .airport-right .btn-book {
        min-height: 44px;

        padding: 10px 20px;

        font-size: 11px;
    }
}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {

    .airport-section {
        padding: 32px 7px 42px;
    }

    .airport-title h2 {
        font-size: 21px;
    }

    .airport-title h2::after {
        width: 60px;

        height: 3px;
    }

    .airport-left {
        padding: 18px 13px;
    }

    .airport-right {
        padding: 20px 14px;
    }

    .airport-left li {
        min-height: 48px;
    }

    .airport-left li strong {
        font-size: 13px;
    }

    .airport-left li span {
        font-size: 12px;

        padding: 6px 7px;
    }

    .airport-right p {
        font-size: 14px;

        line-height: 1.7;
    }
}



/* =========================================================
   BN TAXI - WHY CHOOSE US
   PREMIUM HEAVY ROYAL BLUE + WHITE DESIGN
   Dynamic-safe - existing content/classes preserved
   ========================================================= */

.why-section {
    position: relative;
    overflow: hidden;

    padding: 75px 15px 85px;

    background:
        radial-gradient(
            circle at 8% 15%,
            rgba(21, 87, 214, .08),
            transparent 230px
        ),
        radial-gradient(
            circle at 94% 82%,
            rgba(21, 87, 214, .07),
            transparent 230px
        ),
        linear-gradient(
            135deg,
            #eaf3ff 0%,
            #f8fbff 48%,
            #e8f2ff 100%
        );
}


/* =========================================================
   DECORATIVE BACKGROUND
   ========================================================= */

.why-section::before {
    content: "";

    position: absolute;

    width: 430px;
    height: 430px;

    right: -250px;
    top: -245px;

    border: 65px solid rgba(21, 87, 214, .055);

    border-radius: 50%;

    pointer-events: none;
}


.why-section::after {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    left: -205px;
    bottom: -205px;

    border: 45px solid rgba(21, 87, 214, .045);

    border-radius: 50%;

    pointer-events: none;
}


/* =========================================================
   HEADER
   ========================================================= */

.why-header {
    position: relative;

    z-index: 2;

    max-width: 850px;

    margin: 0 auto 45px;

    text-align: center;
}


.why-header h2 {
    position: relative;

    display: inline-block;

    margin: 0 0 17px;

    padding-bottom: 14px;

    color: #082f7d;

    font-size: clamp(27px, 3.5vw, 38px);

    line-height: 1.15;

    font-weight: 850;

    letter-spacing: -.6px;
}


/* Heading underline */

.why-header h2::after {
    content: "";

    position: absolute;

    left: 50%;
    bottom: 0;

    transform: translateX(-50%);

    width: 72px;
    height: 4px;

    border-radius: 20px;

    background:
        linear-gradient(
            90deg,
            #082f7d,
            #1557d6
        );
}


.why-header p {
    margin: 0;

    color: #586a82;

    font-size: 16px;

    line-height: 1.8;

    font-weight: 500;
}


/* =========================================================
   GRID
   ========================================================= */

.why-grid {
    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 20px;

    max-width: 1120px;

    margin: 0 auto;
}


/* =========================================================
   CARD
   ========================================================= */

.why-card {
    position: relative;

    overflow: hidden;

    min-height: 315px;

    padding: 30px 22px 27px;

    box-sizing: border-box;

    background:
        linear-gradient(
            145deg,
            #ffffff 0%,
            #ffffff 70%,
            #f1f7ff 100%
        );

    border:
        1px solid rgba(21, 87, 214, .12);

    border-radius: 20px;

    text-align: center;

    box-shadow:
        0 18px 45px rgba(8, 47, 125, .11),
        0 5px 15px rgba(8, 47, 125, .05);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}


/* Top blue line */

.why-card::before {
    content: "";

    position: absolute;

    top: 0;
    left: 0;

    width: 100%;
    height: 4px;

    background:
        linear-gradient(
            90deg,
            #082f7d,
            #1557d6,
            #082f7d
        );
}


/* Decorative circle */

.why-card::after {
    content: "";

    position: absolute;

    width: 125px;
    height: 125px;

    right: -80px;
    bottom: -80px;

    border:
        20px solid rgba(21, 87, 214, .045);

    border-radius: 50%;

    pointer-events: none;
}


/* Hover */

.why-card:hover {
    transform: translateY(-7px);

    border-color:
        rgba(21, 87, 214, .25);

    box-shadow:
        0 27px 55px rgba(8, 47, 125, .16),
        0 7px 20px rgba(8, 47, 125, .07);
}


/* =========================================================
   ICON
   ========================================================= */

.why-icon {
    position: relative;

    z-index: 2;

    width: 70px;
    height: 70px;

    margin: 5px auto 22px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 18px;

    background:
        linear-gradient(
            135deg,
            #1557d6,
            #0b3d9e
        );

    color: #ffffff;

    font-size: 25px;

    box-shadow:
        0 12px 25px rgba(21, 87, 214, .25);

    transition:
        transform .25s ease,
        border-radius .25s ease,
        box-shadow .25s ease;
}


.why-card:hover .why-icon {
    transform:
        translateY(-3px)
        rotate(-2deg);

    border-radius: 15px;

    box-shadow:
        0 15px 30px rgba(21, 87, 214, .30);
}


/* =========================================================
   CARD TITLE
   ========================================================= */

.why-card h3 {
    position: relative;

    z-index: 2;

    margin: 0 0 12px;

    color: #10264c;

    font-size: 16px;

    line-height: 1.35;

    font-weight: 850;
}


/* =========================================================
   CARD TEXT
   ========================================================= */

.why-card p {
    position: relative;

    z-index: 2;

    margin: 0;

    color: #63738a;

    font-size: 11.5px;

    line-height: 1.8;

    font-weight: 500;
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 1100px) {

    .why-grid {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        max-width: 800px;

        gap: 18px;
    }

    .why-card {
        min-height: 295px;
    }
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767px) {

    .why-section {
        padding: 48px 10px 55px;
    }

    .why-header {
        margin-bottom: 30px;
    }

    .why-header h2 {
        font-size: 26px;

        margin-bottom: 14px;
    }

    .why-header p {
        font-size: 14px;

        line-height: 1.7;
    }

    .why-grid {
        grid-template-columns: 1fr;

        max-width: 500px;

        gap: 14px;
    }

    .why-card {
        min-height: auto;

        padding: 25px 20px 24px;

        border-radius: 17px;
    }

    .why-icon {
        width: 62px;
        height: 62px;

        margin-bottom: 17px;

        border-radius: 15px;

        font-size: 22px;
    }

    .why-card h3 {
        font-size: 15px;

        margin-bottom: 9px;
    }

    .why-card p {
        font-size: 11px;

        line-height: 1.75;
    }
}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 480px) {

    .why-section {
        padding: 38px 7px 45px;
    }

    .why-header h2 {
        font-size: 23px;
    }

    .why-header p {
        font-size: 14px;
    }

    .why-card {
        padding: 22px 16px;

        border-radius: 15px;
    }

    .why-icon {
        width: 58px;
        height: 58px;

        margin-bottom: 15px;

        font-size: 20px;
    }

    .why-card h3 {
        font-size: 14px;
    }

    .why-card p {
        font-size: 14px;
    }
}



.bn-map{height:450px;background:#e8eef6 linear-gradient(135deg,#eef3fa 25%,#e3eaf4 25%,#e3eaf4 50%,#eef3fa 50%,#eef3fa 75%,#e3eaf4 75%) 0 0/40px 40px;display:flex;align-items:center;justify-content:center}
.bn-map iframe{width:100%;height:100%;border:0;display:block}
.bn-map-btn{background:#0856b0;color:#fff;border:0;border-radius:8px;padding:12px 20px;font-size:16px;font-weight:600;cursor:pointer}
.bn-map-btn:hover{background:#06428a}
.testimonial_section .section_title .bn-about-kicker{font-family:"Open Sans",sans-serif;font-weight:400;font-size:15px;line-height:28px;color:#818a8f;margin:-5px 0 6px}
/* Below-the-fold sections: the browser skips their layout/paint until they're scrolled near.
   The sizes are placeholders (measured heights) so the scrollbar doesn't jump. */
.airport-section,.why-section,.testimonial_section,.bn-routes-section>.container,.bn-footer>.container{content-visibility:auto}
.airport-section{contain-intrinsic-size:auto 1080px}
.why-section{contain-intrinsic-size:auto 1330px}
.testimonial_section{contain-intrinsic-size:auto 1120px}
.bn-routes-section>.container{contain-intrinsic-size:auto 1680px}
.bn-footer>.container{contain-intrinsic-size:auto 1280px}
@media (min-width:992px){
.airport-section{contain-intrinsic-size:auto 780px}
.why-section{contain-intrinsic-size:auto 650px}
.testimonial_section{contain-intrinsic-size:auto 620px}
.bn-routes-section>.container{contain-intrinsic-size:auto 960px}
.bn-footer>.container{contain-intrinsic-size:auto 680px}
}
.banner_bottom span{background-color:#1a73e8}
.banner_bottom h1{margin:0;text-align:center;color:#fff;font-size:18px;line-height:35px;font-family:Quicksand,sans-serif;font-weight:700}
@media (max-width:768px){.banner_bottom h1{font-size:15px}}
        </style>
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
                            <style>
                                /* ---- two-tone split: navy "About Us" (left) + blue testimonial panel (right) ---- */
                                .testimonial_section{overflow:hidden}
                                .testimonial_section > .container{max-width:1180px}
                                /* let the two coloured panels butt together (kill the grid gutter here) */
                                .testimonial_section > .container > .row{margin-left:0;margin-right:0}
                                .testimonial_section > .container > .row > .col-lg-7{padding-left:0;padding-right:0}
                                .testimonial_section > .container > .row > .col-lg-5{padding-left:0;padding-right:0}

                                /* wide right gutter so the About text clears the overlapping card */
                                .testimonial_section .about_content{padding:82px 210px 82px 0 !important}

                                .testimonial_section .col-lg-5{
                                    position:relative;
                                    display:flex;
                                    align-items:center;
                                    margin-left:-24px;
                                    padding:90px 46px 90px 0;
                                    background:linear-gradient(150deg,#0d5bd8 0%,#0846ac 55%,#063a8f 100%);
                                }
                                /* bleed the blue to the right edge of the viewport */
                                .testimonial_section .col-lg-5::after{
                                    content:"";position:absolute;top:0;bottom:0;left:100%;width:60vw;
                                    background:#063a8f;pointer-events:none;
                                }
                                /* faint quote-mark watermark on the blue */
                                .testimonial_section .col-lg-5::before{
                                    content:"\201C";position:absolute;right:34px;top:14px;
                                    font:900 180px/1 Georgia,"Times New Roman",serif;color:rgba(255,255,255,.09);
                                    pointer-events:none;
                                }

                                /* the card is pulled left so it straddles the navy / blue seam */
                                .bn-tm-wrap{position:relative;z-index:2;width:100%;margin-left:-150px;background:#fff;border-radius:18px;
                                    padding:46px 32px 32px;box-shadow:0 46px 90px -30px rgba(3,18,54,.6),0 12px 30px rgba(3,18,54,.32)}
                                .bn-tm-wrap,.bn-tm-wrap *{box-sizing:border-box;min-width:0}

                                /* logo chip overlapping the top-left of the card */
                                .bn-tm-badge{position:absolute;top:-26px;left:32px;display:flex;align-items:center;
                                    background:#fff;border:1px solid #e8edf3;border-radius:13px;padding:9px 16px;
                                    box-shadow:0 16px 34px -12px rgba(3,18,54,.45);z-index:3}
                                .bn-tm-badge img{height:28px;width:auto;display:block}

                                .bn-tm-head{margin-bottom:16px;padding-right:78px}
                                .bn-tm-kicker{display:inline-block;font-size:10.5px;letter-spacing:2.3px;font-weight:800;color:#0757d9;background:#eaf2ff;padding:5px 11px;border-radius:999px}
                                .bn-tm-head h3{margin:11px 0 0;font-size:19.5px;font-weight:800;color:#12233d;letter-spacing:-.2px}
                                .testimonialSwiper{overflow:hidden;padding-bottom:38px;width:100%}
                                .testimonialSwiper{overflow:hidden;position:relative}.testimonialSwiper .swiper-wrapper{display:flex}.testimonialSwiper .swiper-slide{flex:0 0 100%;min-width:100%;height:auto}
                                .bn-tm-card{position:relative;padding:4px 2px 2px}
                                .bn-tm-quotemark{position:absolute;top:-14px;right:2px;font-size:84px;line-height:1;font-family:Georgia,"Times New Roman",serif;color:#0757d9;opacity:.12;pointer-events:none}
                                .bn-tm-stars{color:#f5a623;font-size:14px;letter-spacing:2px;margin-bottom:12px}
                                .bn-tm-text{font-size:15px;line-height:1.75;color:#3a4a60;min-height:120px;margin:0 0 18px;overflow-wrap:anywhere}
                                .bn-tm-person{display:flex;align-items:center;gap:14px;border-top:1px solid #eef2f7;padding-top:18px}
                                .bn-tm-avatar{width:52px;height:52px;border-radius:50%;object-fit:cover;border:3px solid #eaf2ff;flex:0 0 52px}
                                .bn-tm-meta strong{display:block;font-size:15px;color:#12233d;font-weight:800}
                                .bn-tm-meta span{display:block;font-size:12.5px;color:#5c6b7e;text-transform:capitalize;margin-top:2px}
                                .bn-tm-pagination{position:absolute;bottom:12px;left:0;width:100%;text-align:center;line-height:0}
                                .bn-tm-pagination .swiper-pagination-bullet{width:8px;height:8px;background:#c6d2e2;opacity:1;transition:width .25s,background .25s}
                                .bn-tm-pagination .swiper-pagination-bullet-active{width:24px;border-radius:6px;background:#0757d9}
                                .bn-tm-nav{position:absolute;top:28px;right:24px;display:flex;gap:8px;z-index:3}
                                .bn-tm-nav button{width:34px;height:34px;border-radius:50%;border:1px solid #dbe4ef;background:#fff;color:#0757d9;font-size:12px;cursor:pointer;transition:.2s;display:flex;align-items:center;justify-content:center}
                                .bn-tm-nav button:hover{background:#0757d9;color:#fff;border-color:#0757d9}

                                /* legacy decorative panel no longer used */
                                .testimonial_section .testimonial_box .testimonial_container{background:transparent !important;margin-left:0 !important}
                                .testimonial_section .testimonial_box .testimonial_container .background_layer{display:none !important}

                                /* stack cleanly below lg — drop the overlap */
                                @media (max-width:991px){
                                    .testimonial_section .about_content{padding:44px 22px !important}
                                    .testimonial_section .about_content .background_layer{width:100% !important;margin:0 !important}
                                    .testimonial_section .col-lg-5{padding:52px 22px 44px}
                                    .testimonial_section .col-lg-5::after{display:none}
                                    .testimonial_section .col-lg-5::before{font-size:130px;right:14px}
                                    .bn-tm-wrap{margin-left:0;padding:46px 26px 28px}
                                }
                                @media (max-width:575px){
                                    .testimonial_section .col-lg-5{padding:44px 16px 34px}
                                    .bn-tm-wrap{padding:44px 20px 26px}
                                    .bn-tm-text{min-height:0}
                                    .bn-tm-nav{display:none}
                                    .bn-tm-head{padding-right:0}
                                    .bn-tm-badge{left:20px}
                                }
                            </style>

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
