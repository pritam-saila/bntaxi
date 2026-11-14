<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')
        
        
        @stylesheet('goods/css/pages/news.css')
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