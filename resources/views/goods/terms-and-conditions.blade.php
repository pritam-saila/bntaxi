<!doctype html>
<html>
    <head>
        
        <meta charset="UTF-8">
         <title>Terms and Conditions | BN Taxi Anytime - Brighton Taxi Company</title>
  <meta name="description" content="Learn about BN Taxi Anytime, Brighton's trusted local taxi company. Licensed drivers, a modern fleet, and years of experience serving Brighton & Hove.">
  <meta name="keywords" content="Brighton taxi company ">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        @include('goods.include.assets')
        
        <style>
/* ===========================
   BN Taxi Anytime Terms Page
===========================*/

body{
    font-family:'Poppins',sans-serif;
    background:#f5f7fb;
    color:#444;
}

.policy-icon{
    width:52px !important;
    height:52px !important;
    min-width:52px;
    min-height:52px;
    background:#0d6efd;
    border-radius:12px;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    flex-shrink:0;
}

.policy-icon i{
    display:block !important;
    font-family:"Font Awesome 6 Free" !important;
    font-weight:900 !important;
    font-size:18px !important;
    color:#fff !important;
    line-height:1 !important;
}

/* HERO */

.terms-banner{

    background:linear-gradient(135deg,#071a3d,#0d6efd);

    padding:80px 0;

    color:#fff;

    overflow:hidden;

}

.page-tag{

display:inline-block;

background:rgba(255,255,255,.15);

padding:8px 18px;

border-radius:30px;

font-size:14px;

margin-bottom:20px;

}

.page-tag i{

margin-right:8px;

color:#ffc107;

}

.terms-banner h1{

font-size:48px;

font-weight:700;

margin-bottom:15px;

}

.terms-banner p{

font-size:17px;

line-height:1.8;

opacity:.95;

}

.banner-image{

border-radius:18px;

box-shadow:0 15px 35px rgba(0,0,0,.25);

}

/* CARD */

.policy-card{

background:#fff;

border-radius:18px;

padding:30px;

margin-bottom:30px;

box-shadow:0 10px 30px rgba(0,0,0,.08);

transition:.35s;

border:1px solid #edf1f7;

}

.policy-card:hover{

transform:translateY(-6px);

box-shadow:0 18px 40px rgba(0,0,0,.12);

}

/* HEADER */

.policy-header{

display:flex;

align-items:center;

gap:18px;

margin-bottom:25px;

padding-bottom:18px;

border-bottom:1px solid #ececec;

}

.policy-header h2{

font-size:26px;

margin:0;

font-weight:700;

color:#071a3d;

}

.policy-header p{

margin-top:5px;

font-size:15px;

color:#777;

}

/* ICON */

.policy-icon{

width:52px;

height:52px;

border-radius:14px;

display:flex;

align-items:center;

justify-content:center;

font-size:18px;

color:#fff;

flex-shrink:0;

}

.primary{background:#0d6efd;}
.success{background:#198754;}
.warning{background:#f59e0b;}
.danger{background:#dc3545;}
.info{background:#06b6d4;}
.secondary{background:#6c757d;}
.dark{background:#212529;}

/* LIST */

.policy-list{

list-style:none;

padding:0;

margin:0;

}

.policy-list li{

display:flex;

align-items:flex-start;

gap:12px;

padding:14px 0;

border-bottom:1px solid #edf1f7;

font-size:15px;

line-height:1.8;

transition:.3s;

}

.policy-list li:last-child{

border-bottom:none;

}

.policy-list li i{

width:22px;

height:22px;

background:#0d6efd;

color:#fff;

border-radius:50%;

display:flex;

justify-content:center;

align-items:center;

font-size:10px;

flex-shrink:0;

margin-top:4px;

transition:.3s;

}

.policy-list li:hover{

padding-left:8px;

color:#0d6efd;

}

.policy-list li:hover i{

background:#ffc107;

color:#000;

}

/* CONTACT */

.contact-card{

background:linear-gradient(135deg,#071a3d,#0d6efd);

border-radius:20px;

padding:60px 30px;

text-align:center;

color:#fff;

margin-top:50px;

}

.contact-card h2{

font-size:36px;

font-weight:700;

margin-bottom:15px;

}

.contact-card p{

font-size:17px;

opacity:.95;

max-width:650px;

margin:auto;

}

.contact-card .btn{

padding:14px 35px;

border-radius:40px;

font-weight:600;

font-size:17px;

transition:.3s;

}

.contact-card .btn:hover{

transform:translateY(-3px);

}

/* Responsive */

@media(max-width:991px){

.terms-banner{

text-align:center;

}

.banner-image{

margin-top:35px;

}

.policy-header{

flex-direction:row;

align-items:flex-start;

}

.policy-header h2{

font-size:22px;

}

.terms-banner h1{

font-size:34px;

}

.contact-card{

padding:40px 20px;

}

.contact-card h2{

font-size:28px;

}

.policy-list li {
    display: -webkit-box;

}


        </style>
    </head>
    <body>
        @include('goods.include.header')


<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

<section class="terms-banner">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-8">

                <span class="page-tag">
                    <i class="fa-solid fa-shield-halved"></i>
                    BN Taxi Anytime
                </span>

                <h1>Terms & Conditions</h1>

                <p>
                    Please read these Terms & Conditions carefully before using our services.
                    These terms explain your rights, responsibilities and important booking information.
                </p>

            </div>

            <!-- <div class="col-lg-4 text-center">

                <img src="https://bntaxianytime.com/wp-content/uploads/Bntaxianytime.jpg"
                     class="img-fluid banner-image"
                     alt="BN Taxi Anytime">

            </div> -->

        </div>
    </div>
</section>


<section class="py-5">

<div class="container">

<!-- PAYMENT -->

<div class="policy-card mb-4">

<div class="policy-header">

<div class="policy-icon">

<i class="fa-solid fa-credit-card"></i>
</div>

<div>

<h2>Payment</h2>

<p class="mb-0">
Payment information for all bookings.
</p>

</div>

</div>

<ul class="policy-list">

<li>

<i class="fas fa-angle-right"></i>

Payments made by credit or debit card will appear on your statement as <strong>BNTAXIANYTIME</strong>.

</li>

<li>

<i class="fas fa-angle-right"></i>

Car parking charges incurred during your journey will be charged at cost unless included as part of our Airport Meet &amp; Greet service.

</li>

<li>

<i class="fas fa-angle-right"></i>

Additional mileage or waiting time may incur extra charges.

</li>

</ul>

</div>



<!-- CANCELLATION -->

<div class="policy-card">

<div class="policy-header">

<div class="policy-icon danger">

<i class="fas fa-ban"></i>

</div>

<div>

<h2>Cancellation Policy</h2>

<p class="mb-0">

Important cancellation information.

</p>

</div>

</div>

<ul class="policy-list">

<li>

<i class="fas fa-angle-right"></i>

Bookings cancelled within 4 hours of the scheduled pickup time may be charged the full fare.

</li>

<li>

<i class="fas fa-angle-right"></i>

No-show bookings may be charged the full journey fare.

</li>

</ul>

</div>

<!-- =========================================
TERMS & CONDITIONS
==========================================-->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon success">
            <i class="fas fa-file-contract"></i>
        </div>

        <div>
            <h2>Terms & Conditions</h2>
            <p class="mb-0">
                Please read the following terms carefully before travelling with BN Taxi Anytime.
            </p>
        </div>

    </div>

    <ul class="policy-list">

        <li><i class="fas fa-angle-right"></i> We will make every effort to arrive on time. However, BN Taxi Anytime cannot accept responsibility for delays caused by traffic, accidents, vehicle breakdowns, or severe weather.</li>

        <li><i class="fas fa-angle-right"></i> Online bookings require a minimum of 24 hours’ notice.</li>

        <li><i class="fas fa-angle-right"></i> For bookings within 24 hours, please call <strong>01273 757373</strong> or <strong>07491 757373</strong>.</li>

        <li><i class="fas fa-angle-right"></i> All drivers comply with UK road laws and speed limits at all times.</li>

        <li><i class="fas fa-angle-right"></i> Additional pick-up or drop-off locations are subject to availability and may incur additional charges.</li>

        <li><i class="fas fa-angle-right"></i> Waiting time is chargeable at the standard rate.</li>

        <li><i class="fas fa-angle-right"></i> Your statutory rights remain unaffected.</li>

        <li><i class="fas fa-angle-right"></i> A 10-minute grace period applies to all non-airport collections before waiting charges begin.</li>

        <li><i class="fas fa-angle-right"></i> Passengers under the influence of alcohol or drugs, or displaying abusive or threatening behaviour, may be refused travel.</li>

        <li><i class="fas fa-angle-right"></i> Cleaning charges may apply if a vehicle is left excessively dirty.</li>

        <li><i class="fas fa-angle-right"></i> Your email address will never be shared with third parties.</li>

        <li><i class="fas fa-angle-right"></i> Lost property is retained for up to 14 days before being handed to Brighton Police Station.</li>

        <li><i class="fas fa-angle-right"></i> Smoking and vaping are strictly prohibited in all vehicles.</li>

        <li><i class="fas fa-angle-right"></i> Prices may vary during public holidays. Please call <strong>01273 757373</strong> or <strong>07491 757373</strong> for details.</li>

        <li><i class="fas fa-angle-right"></i> All out-of-town journeys must be paid for in advance.</li>

        <li><i class="fas fa-angle-right"></i> Bookings must only be made through our office, website, or mobile app.</li>

        <li><i class="fas fa-angle-right"></i> Telephone calls may be recorded for training, quality assurance, and security purposes.</li>

        <li><i class="fas fa-angle-right"></i> We operate a Zero Tolerance Policy towards abusive or threatening behaviour. Operators reserve the right to terminate calls immediately if abuse occurs.</li>

    </ul>

</div>




<!-- =========================================
BOOKING & JOURNEY
==========================================-->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon warning">
            <i class="fas fa-route"></i>
        </div>

        <div>

            <h2>Booking & Journey</h2>

            <p class="mb-0">
                Booking information and passenger responsibilities.
            </p>

        </div>

    </div>

    <ul class="policy-list">

        <li><i class="fas fa-angle-right"></i> Passenger Responsibility: Please ensure all booking details (pickup time, address, destination, and contact information) are correct.</li>

        <li><i class="fas fa-angle-right"></i> Vehicle Capacity: Passengers are responsible for booking a vehicle suitable for the number of passengers and luggage. Drivers may refuse travel if the vehicle capacity is exceeded.</li>

        <li><i class="fas fa-angle-right"></i> Child Seats: Child seats are available upon request, subject to availability. Customers are responsible for requesting them when booking.</li>

        <li><i class="fas fa-angle-right"></i> Route Changes: Any changes to the destination or route after the journey has commenced may result in additional charges.</li>

    </ul>

</div>





<!-- =========================================
AIRPORT TRANSFERS
==========================================-->

<div class="policy-card mb-5">

    <div class="policy-header">

        <div class="policy-icon primary">
            <i class="fas fa-plane-departure"></i>
        </div>

        <div>

            <h2>Airport Transfers</h2>

            <p class="mb-0">
                Airport collection and transfer information.
            </p>

        </div>

    </div>

    <ul class="policy-list">

        <li><i class="fas fa-angle-right"></i> Flight arrival times are monitored where flight details have been provided.</li>

        <li><i class="fas fa-angle-right"></i> Delays or changes to flight information must be communicated as soon as possible.</li>

        <li><i class="fas fa-angle-right"></i> Additional waiting time beyond the complimentary airport waiting period may be chargeable.</li>

    </ul>

</div>
<!-- =======================================
PAYMENTS & CHARGES
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon info">
            <i class="fas fa-wallet"></i>
        </div>

        <div>
            <h2>Payments & Charges</h2>
            <p class="mb-0">Payment verification and additional charges.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            Card payments may be subject to verification for security purposes.
        </li>

        <li>
            <i class="fas fa-chevron-right"></i>
            Receipts are available upon request.
        </li>

        <li>
            <i class="fas fa-chevron-right"></i>
            Any tolls, congestion charges, or ferry charges not included in the quoted fare will be added where applicable.
        </li>

    </ul>

</div>


<!-- =======================================
LUGGAGE
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon secondary">
            <i class="fas fa-suitcase"></i>
        </div>

        <div>
            <h2>Luggage</h2>
            <p class="mb-0">Passenger luggage responsibilities.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            Passengers are responsible for ensuring all luggage and personal belongings are loaded and unloaded from the vehicle.
        </li>

        <li>
            <i class="fas fa-chevron-right"></i>
            We cannot accept liability for items left in the vehicle, although every effort will be made to return lost property.
        </li>

    </ul>

</div>


<!-- =======================================
PETS
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon warning">
            <i class="fas fa-paw"></i>
        </div>

        <div>
            <h2>Pets</h2>
            <p class="mb-0">Travelling with pets.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            Assistance dogs are always welcome.
        </li>

        <li>
            <i class="fas fa-chevron-right"></i>
            Other pets may travel by prior arrangement and at the driver's discretion.
        </li>

    </ul>

</div>


<!-- =======================================
SAFETY
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon danger">
            <i class="fas fa-shield-alt"></i>
        </div>

        <div>
            <h2>Safety</h2>
            <p class="mb-0">Passenger and driver safety.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            Seat belts must be worn by all passengers where legally required.
        </li>

        <li>
            <i class="fas fa-chevron-right"></i>
            Drivers reserve the right to refuse travel if they believe it would compromise the safety of passengers, the driver, or the vehicle.
        </li>

    </ul>

</div>


<!-- =======================================
PRIVACY
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon primary">
            <i class="fas fa-user-shield"></i>
        </div>

        <div>
            <h2>Privacy</h2>
            <p class="mb-0">How your information is protected.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            Personal information is processed in accordance with our Privacy Policy and applicable UK data protection laws.
        </li>

    </ul>

</div>


<!-- =======================================
COMPLAINTS
======================================= -->

<div class="policy-card mb-4">

    <div class="policy-header">

        <div class="policy-icon success">
            <i class="fas fa-headset"></i>
        </div>

        <div>
            <h2>Complaints</h2>
            <p class="mb-0">Customer support and feedback.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            If you are dissatisfied with our service, please contact us within 7 days of your journey so we can investigate and resolve the issue promptly.
        </li>

    </ul>

</div>


<!-- =======================================
LIABILITY
======================================= -->

<div class="policy-card mb-5">

    <div class="policy-header">

        <div class="policy-icon dark">
            <i class="fas fa-scale-balanced"></i>
        </div>

        <div>
            <h2>Liability</h2>
            <p class="mb-0">Important liability information.</p>
        </div>

    </div>

    <ul class="policy-list">

        <li>
            <i class="fas fa-chevron-right"></i>
            While we take every reasonable care, BN Taxi Anytime shall not be liable for indirect losses, missed connections, missed appointments, or consequential losses arising from delays beyond our reasonable control.
        </li>

    </ul>

</div>




</div>

</section>





        @include('goods.include.footer')
    </body>
</html>
