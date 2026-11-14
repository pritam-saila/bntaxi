<!doctype html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Airport Transfers Brighton | BN Taxi Anytime</title>
        <meta name="description" content="Book reliable airport transfers from Brighton to Gatwick, Heathrow & other UK airports. Fixed prices, flight monitoring and meet & greet service.">
        <meta name="keywords" content="Airport transfers Brighton ">

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

/* TITLE */
.page-title {
    font-size: 34px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #1a1a1a;
}

/* TEXT */
.col-lg-8 p {
    font-size: 15px;
    line-height: 1.9;
    color: #555;
}

/* HIGHLIGHT TEXT */
.highlight {
    font-weight: 600;
    background: #f1f6ff;
    padding: 8px 12px;
    border-left: 4px solid #007bff;
    border-radius: 4px;
}

/* LIST */
.airport-list {
    margin: 15px 0;
    padding-left: 20px;
}

.airport-list li {
    margin-bottom: 6px;
    color: #007bff;
    font-weight: 500;
}

/* SUB TITLE */
.sub-title {
    margin-top: 30px;
    font-size: 22px;
    font-weight: 600;
}

/* FEATURES */
.feature-list {
    margin-top: 15px;
    padding-left: 20px;
}

.feature-list li {
    margin-bottom: 12px;
    line-height: 1.7;
    color: #444;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .page-title {
        font-size: 26px;
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

    <h1 class="page-title">Brighton Airport Taxis</h1>

    <p>
        BN Taxi anytime understands your travelling needs and is here with convenient options for you.
        Our Airport Taxi Service is reliable and trustworthy. Brighton is a busy town with lots of
        commuters on road daily. Reaching the airport on time can be challenging, and we make it easy.
    </p>

    <p class="highlight">
        Brighton Airport Taxi Service by BN Taxi anytime
    </p>

    <p>
        We provide excellent airport transfer service in Brighton to make sure you never miss a flight.
        We connect you to all major airports including:
    </p>

    <ul class="airport-list">
        <li>Gatwick Airport</li>
        <li>Heathrow Airport</li>
        <li>Central London</li>
        <li>All other major London Airports</li>
    </ul>

    <p>
        We provide both-way travel solutions. Book your taxi, sit back and relax while we ensure
        timely arrival without any hiccups.
    </p>

    <h3 class="sub-title">Why Choose Our Brighton Airport Taxi?</h3>

    <ol class="feature-list">
        <li>
            <strong>Punctuality:</strong> Airport transfers are time sensitive. We ensure on-time service
            so you never miss your flight.
        </li>

        <li>
            <strong>Driver Expertise:</strong> Our drivers are well trained and familiar with all city routes.
        </li>

        <li>
            <strong>Wide Range of Cars:</strong> Choose from a variety of cars as per your travel needs.
        </li>

        <li>
            <strong>Reliability & Security:</strong> GPS tracking and safe travel ensured at all times.
        </li>

        <li>
            <strong>Affordable Cost:</strong> Transparent pricing with no hidden charges.
        </li>

        <li>
            <strong>Online & Offline Booking:</strong> Book anytime via website or phone.
        </li>
    </ol>

</div>

            <!-- RIGHT SIDEBAR -->
            <div class="col-lg-4">

                <div class="image-box">
                    <img src="{{url('goods')}}/images/services.jpg" alt="Taxi">
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
