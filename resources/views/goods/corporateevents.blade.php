<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Corporate Event Transport Brighton | BN Taxi Anytime </title>
        <meta name="description" content="Professional group transport for corporate events, conferences & business functions in Brighton. Reliable transfers with experienced drivers. ">
        <meta name="keywords" content="Corporate event transport Brighton ">

        @include('goods.include.assets')
        
        <style>
           
           
           /* SECTION */
.service-section {
    background: #f5f7fb;
    padding: 80px 0;
}

/* TITLE */
.title {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 25px;
    color: #1a1a1a;
}

/* TEXT */
.service-section p {
    font-size: 15px;
    line-height: 1.9;
    color: #555;
    margin-bottom: 15px;
}

/* IMAGE BOX */
.image-box img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* SIDEBAR */
.sidebar {
    margin-top: 20px;
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
}

.sidebar h4 {
    font-size: 20px;
    margin-bottom: 15px;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin-bottom: 10px;
}

.sidebar ul li a {
    color: #007bff;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar ul li a:hover {
    padding-left: 6px;
    color: #0056b3;
}

/* 🔥 HEAVY CTA BUTTON */
.btn-book {
    display: inline-block;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: #fff;
    padding: 14px 30px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 6px;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 8px 20px rgba(0,123,255,0.3);
}

.btn-book:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(0,123,255,0.4);
    color: #fff;
}

/* FULL WIDTH BUTTON */
.w-100 {
    display: block;
    text-align: center;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .title {
        font-size: 28px;
    }

    .service-section {
        padding: 50px 0;
    }
}
           
        </style>
    </head>
    <body>
        @include('goods.include.header')

        <!-- ================= BANNER ================= -->
        <section class="banner">
            <div class="container banner-content">
                <h1>BN Taxi Anytime</h1>
                <p>Reliable & Professional Brighton Taxi Service</p>
            </div>
        </section>

      <section class="service-section">
    <div class="container">

        <!-- TOP CTA -->
        

        <div class="row">

            <!-- LEFT CONTENT -->
            <div class="col-lg-8">

    <h1 class="page-title">Luxury Car Hire in Brighton</h1>

    <p>
        At BN Taxi anytime, we provide premium luxury car hire services in Brighton for corporate events,
        high-profile gatherings, and personal travel where comfort and class matter.
    </p>

    <p>
        Luxury is not just about style — it’s about experience. Our fleet offers top-quality vehicles
        that deliver both comfort and elegance without the burden of ownership and maintenance costs.
    </p>

    <p>
        We maintain all vehicles to the highest standards with proper documentation and regular servicing.
        Whether it's a wedding, executive meeting, or VIP travel, we ensure a flawless journey.
    </p>

    <p>
        Enjoy chauffeur-driven services with professional, licensed drivers dressed in proper uniform,
        ensuring safety, privacy, and top-class etiquette throughout your journey.
    </p>

    <p>
        Our services are affordable and accessible, allowing you to enjoy luxury travel without high costs.
        Available 24/7, we ensure your travel plans are smooth and stress-free.
    </p>

    <p>
        Our Corporate Account Service allows regular business clients to manage bookings easily
        with flexible payment and invoicing options.
    </p>

    <p>
        Book your luxury car today through our website or call us for instant booking assistance.
    </p>

</div>

            <!-- RIGHT SIDEBAR -->
            <div class="col-lg-4">

                <div class="image-box">
                    <img src="{{url('goods')}}/images/gallery-131.jpg" alt="Taxi">
                </div>

                <div class="sidebar">
                    

                    <!-- CTA INSIDE -->
                    <a href="" class="btn-book w-100 mt-3">Book Now</a>
                </div>
               
            </div>

        </div>
    </div>
</section>
       
       
        @include('goods.include.footer')
    </body>
</html>
