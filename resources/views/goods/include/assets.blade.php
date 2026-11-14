@php
    // The homepage passes ['lean' => true]: it gets one trimmed, inlined stylesheet
    // (public/goods/css/home.min.css, built by `npm run build:home-css`) and no jQuery/Bootstrap JS,
    // because nothing on it uses them. Every other page keeps the full set of assets.
    $lean = $lean ?? false;
    $homeCssFile = $lean ? \App\Support\SiteAssets::path('goods/css/home.min.css') : null;
    $homeCss = $homeCssFile ? @file_get_contents($homeCssFile) : false;
    // When the homepage CSS is inlined, @stylesheet(...) in the templates prints nothing
    // (header.css, footer.css etc. are already part of home.min.css).
    \App\Support\SiteAssets::$bundled = (bool) $homeCss;

    // SEO: one canonical address per page. The site answers on www/non-www and http/https,
    // so always point search engines at https://bntaxianytime.com/<path> (from APP_URL).
    $siteUrl = rtrim(config('app.url'), '/');
    $path = trim(request()->path(), '/');
    $canonical = $siteUrl . ($path === '' ? '/' : '/' . $path);
    if (request()->filled('page')) {
        $canonical .= '?page=' . (int) request()->query('page');
    }
@endphp
{{-- Debug marker: shows which stylesheet mode the page is using (view-source and search "css-mode"). --}}
<!-- css-mode: {{ $homeCss ? 'inline' : 'files' }} -->
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:site_name" content="BN Taxi Anytime">
<meta property="og:type" content="website">
<meta property="og:locale" content="en_GB">
<meta property="og:url" content="{{ $canonical }}">
@isset($ogTitle)<meta property="og:title" content="{{ $ogTitle }}">
@endisset
@isset($ogDescription)<meta property="og:description" content="{{ $ogDescription }}">
@endisset
<meta property="og:image" content="{{ $siteUrl }}/goods/images/og-share.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="BN Taxi Anytime - Brighton taxi and airport transfers">
<meta name="twitter:card" content="summary_large_image">
@unless ($homeCss)
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
@endunless
<link rel="shortcut icon" href="{{url('goods')}}/images/logo.png">

@if ($homeCss)
<link rel="preload" as="font" type="font/woff2" href="{{ url('goods/fonts/quicksand-latin-700.woff2') }}" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="{{ url('goods/fonts/quicksand-latin-500.woff2') }}" crossorigin>
<link rel="preload" as="font" type="font/woff2" href="{{ url('goods/fonts/fa-solid-900.woff2') }}" crossorigin>
<style>{!! str_replace('__FONTS__', url('goods/fonts'), $homeCss) !!}</style>
@else
@stylesheet('goods/css/style.css')
@stylesheet('goods/css/main.css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
@endif

@unless ($lean)
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endunless



<!--map: disabled - if re-enabled, put the key in .env (GOOGLE_MAPS_KEY) and print it with {{ env('GOOGLE_MAPS_KEY') }}, never hardcode it here -->
<!-- <script src='https://maps.google.com/maps/api/js?libraries=places&key={{ env('GOOGLE_MAPS_KEY') }}'></script> -->
<!--map-->

@unless ($homeCss)
{{-- Web fonts load without blocking the first paint (text shows in a fallback font, then swaps).
     The homepage declares its fonts inside home.min.css (self-hosted in public/goods/fonts). --}}
<link rel="stylesheet" media="print" onload="this.media='all'" href="https://fonts.bunny.net/css?family=lato:400,700,900|quicksand:400,500,600,700&display=swap">
<link rel="stylesheet" media="print" onload="this.media='all'" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,600,700|Open+Sans:400,600,700&display=swap">
<noscript>
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=lato:400,700,900|quicksand:400,500,600,700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,600,700|Open+Sans:400,600,700&display=swap">
</noscript>
@endunless
@unless ($lean)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
@endunless
@unless ($homeCss)
{{-- Icons: the inlined homepage CSS already contains them; every other case needs this file. --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
@endunless

<meta name="google-site-verification" content="TmuHtZOhzz47DRkjIiAbnqHlyaa6L9zAHF8Jq2znLj8" />

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

<!-- Google tag (gtag.js): loaded on the visitor's first interaction (or after 6s) so its
     ~180 KB of script doesn't compete with the page while it is loading. -->
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-22Q92KCXGD');
  (function () {
    var done = false, evts = ['scroll', 'pointerdown', 'keydown', 'touchstart', 'mousemove'];
    function load() {
      if (done) return; done = true;
      evts.forEach(function (e) { window.removeEventListener(e, load); });
      var s = document.createElement('script');
      s.async = true;
      s.src = 'https://www.googletagmanager.com/gtag/js?id=G-22Q92KCXGD';
      document.head.appendChild(s);
    }
    evts.forEach(function (e) { window.addEventListener(e, load, { passive: true, once: true }); });
    window.addEventListener('load', function () { setTimeout(load, 6000); });
  })();
</script>
