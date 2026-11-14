<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $route->title ?? 'Route Details' }} | BN Taxi Anytime</title>
        @if(isset($route))
        <meta name="keywords" content="{{ $route->metatag ?? '' }}">
        <meta name="description" content="{{ $route->metadescription ?? '' }}">
        @endif

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>{{ $route->title ?? 'Route Details' }}</h1>
                <p>{{ $route->subtitle ?? 'Reliable & Professional Brighton Taxi Service'}}</p>
            </div>
        </section>

        <!-- ================= ABOUT ================= -->
        @if(isset($route) && $route->side == 'top')
        <section class="about pt-5 pb-5">
            <div class="container">
                <div class="text-center mb-4">
                    <h2>{{ $route->title ?? 'Route' }}</h2>
                </div>
                
                <div class="text-center mb-4">
                    @if(isset($route->image) && $route->image)
                        <img src="{{ url(Storage::url($route->image)) }}" alt="{{ $route->title }}" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;" />
                    @else
                        <img src="{{url('goods')}}/images/brighton-city-council-logo-about.jpg" alt="Taxi" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto;" />
                    @endif
                </div>

                <div class="route-description" style="width: 100%; line-height: 1.8;">
                    {!! $route->description ?? '<p>Route description not available.</p>' !!}
                </div>

                @if(isset($faqs) && count($faqs) > 0)
                <section class="faq-section">
                    <div class="faq-title">
                        <h2>Frequently Asked Questions</h2>
                        <p>Everything you need to know about this route</p>
                    </div>

                    @foreach($faqs as $faq)
                    <div class="faq-item">
                        <div class="faq-question">
                            {{ $faq->question }}
                            <div class="faq-icon">+</div>
                        </div>
                        <div class="faq-answer">
                            <p>{!! $faq->answer !!}</p>
                        </div>
                    </div>
                    @endforeach
                </section>
                @endif
            </div>
        </section>
        @else
            <section class="about">
                <div class="container about-wrapper">
                    <!-- LEFT -->
                    <div class="about-left">
                        <h2>{{ $route->title ?? 'Route' }}</h2>

                        {!! $route->description ?? '<p>Route description not available.</p>' !!}
                    </div>

                    <!-- RIGHT -->
                    <div class="about-right">
                        @if(isset($route->image) && $route->image)
                            <img src="{{ url(Storage::url($route->image)) }}" alt="{{ $route->title }}" />
                        @else
                            <img src="{{url('goods')}}/images/brighton-city-council-logo-about.jpg" alt="Taxi" />
                        @endif

                        <!-- <div class="license">Fully Licensed by Brighton and Hove City Council</div> -->

                        @if(isset($faqs) && count($faqs) > 0)
                        <section class="faq-section">
                            <div class="faq-title">
                                <h2>Frequently Asked Questions</h2>
                                <p>Everything you need to know about this route</p>
                            </div>

                            @foreach($faqs as $faq)
                            <div class="faq-item">
                                <div class="faq-question">
                                    {{ $faq->question }}
                                    <div class="faq-icon">+</div>
                                </div>
                                <div class="faq-answer">
                                    <p>{!! $faq->answer !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </section>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        @include('goods.include.footer')
        <script>
            document.querySelectorAll(".faq-question").forEach((item) => {
                item.addEventListener("click", () => {
                    const parent = item.parentElement;
                    document.querySelectorAll(".faq-item").forEach((el) => {
                        if (el !== parent) {
                            el.classList.remove("active");
                        }
                    });
                    parent.classList.toggle("active");
                });
            });
        </script>
    </body>
</html>