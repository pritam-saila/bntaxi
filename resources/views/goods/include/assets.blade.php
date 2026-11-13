@php
    // The homepage passes ['lean' => true]: it gets one trimmed, inlined stylesheet
    // (public/goods/css/home.min.css, built by `npm run build:home-css`) and no jQuery/Bootstrap JS,
    // because nothing on it uses them. Every other page keeps the full set of assets.
    $lean = $lean ?? false;
    $homeCss = false;
    if ($lean) {
        // On some hosts the web root (e.g. public_html) is not Laravel's public/ folder,
        // so look in the server's document root as well as public_path().
        $candidates = [public_path('goods/css/home.min.css')];
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/goods/css/home.min.css';
        }
        foreach ($candidates as $file) {
            if (is_file($file) && ($css = @file_get_contents($file))) { $homeCss = $css; break; }
        }
    }
@endphp
{{-- Debug marker: shows which stylesheet mode the page is using (view-source and search "css-mode"). --}}
<!-- css-mode: {{ $homeCss ? 'inline' : 'files' }} -->@unless ($homeCss)
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
<link rel="stylesheet" href="{{ url('goods') }}/css/style.css?v=6">
<link rel="stylesheet" href="{{url('goods')}}/css/main.css?v=6">
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
