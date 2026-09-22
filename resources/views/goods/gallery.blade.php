<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>Gallery</h1>
                <p>Reliable & Professional Brighton Taxi Service</p>
            </div>
        </section>

        <section class="gallery-section">
            <div class="gallery-title">
                <h2>Our Gallery</h2>
                <p>Explore our taxi services and vehicles</p>
            </div>

            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                    <div class="gallery-item">
                        <img src="{{ url(Storage::url($gallery->image)) }}" alt="{{ $gallery->title }}" />
                        <div class="gallery-overlay">{{ $gallery->title }}</div>
                    </div>
                @empty
                    <div class="col-12 text-center" style="width: 100%;">
                        <p>No gallery images available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Lightbox -->
        <div class="lightbox" id="lightbox">
            <span class="lightbox-close">&times;</span>
            <img src="" id="lightbox-img" />
        </div>

        @include('goods.include.footer')

        <script>
            const items = document.querySelectorAll(".gallery-item img");
            const lightbox = document.getElementById("lightbox");
            const lightboxImg = document.getElementById("lightbox-img");
            const closeBtn = document.querySelector(".lightbox-close");

            items.forEach((img) => {
                img.addEventListener("click", () => {
                    lightbox.classList.add("active");
                    lightboxImg.src = img.src;
                });
            });

            closeBtn.addEventListener("click", () => {
                lightbox.classList.remove("active");
            });

            lightbox.addEventListener("click", (e) => {
                if (e.target !== lightboxImg) {
                    lightbox.classList.remove("active");
                }
            });
        </script>
    </body>
</html>
