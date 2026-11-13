@php
    // Pages that don't run inline jQuery while the HTML is being parsed (e.g. the homepage)
    // can pass ['lean' => true] so the JS libraries are deferred and unused CSS is skipped.
    $lean = $lean ?? false;
@endphp
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
<link rel="dns-prefetch" href="https://www.googletagmanager.com">

<link rel="stylesheet" href="{{ url('goods') }}/css/style.css?v=4">
<link rel="stylesheet" href="{{url('goods')}}/css/main.css?v=5">
<link rel="shortcut icon" href="{{url('goods')}}/images/logo.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

@if ($lean)
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@else
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
@endif



<!--map: disabled - if re-enabled, put the key in .env (GOOGLE_MAPS_KEY) and print it with {{ env('GOOGLE_MAPS_KEY') }}, never hardcode it here -->
<!-- <script src='https://maps.google.com/maps/api/js?libraries=places&key={{ env('GOOGLE_MAPS_KEY') }}'></script> -->
<!--map-->

{{-- Web fonts load without blocking the first paint (text shows in a fallback font, then swaps). --}}
<link rel="stylesheet" media="print" onload="this.media='all'" href="https://fonts.bunny.net/css?family=lato:400,700,900|quicksand:400,500,600,700&display=swap">
<link rel="stylesheet" media="print" onload="this.media='all'" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,600,700|Open+Sans:400,600,700&display=swap">
<noscript>
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=lato:400,700,900|quicksand:400,500,600,700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,600,700|Open+Sans:400,600,700&display=swap">
</noscript>
@unless ($lean)
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
@endunless
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

<meta name="google-site-verification" content="TmuHtZOhzz47DRkjIiAbnqHlyaa6L9zAHF8Jq2znLj8" />

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-22Q92KCXGD"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-22Q92KCXGD');
</script>
