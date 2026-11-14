<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BN Taxi Anytime</title>

    
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet">
     
  @include('goods.include.assets')


@stylesheet('goods/css/pages/choose-this-option.css')



@stylesheet('goods/css/pages/choose-this-option-2.css')


  
</head>
<body>
  @include('goods.include.header')

  

  <div class="banners" id="banners">
            <div class="banner-paras">
            <h1>Contact Us</h1>
            <h5>Home // <a href=""> Contact</a> </h5>
            
          </div>
  </div>

<div class="progreess">
<div class="container">
      <div class="progress-container">
        <div class="progress" id="progress"></div>
        <div class="circle active">
            <p>Delivery</p></div>

        <div class="circle">
            <p>Quote</p>
        </div>
        <div class="circle">
            <p>Payment</p>
        </div>
      </div>
      <button class="btn" id="prev" disabled>Prev</button>
      <button class="btn" id="next">Next</button>
    </div>
</div>

<div class="main-forms">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Your details:</h2>
            <form>
                <div class="row">
                    <div class="col-md-6">
                       <div class="small-vans">
                        <label>First Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div> 
                    </div>
                    <div class="col-md-6">
                       <div class="small-vans">
                        <label>Last Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div> 
                    </div>
                    <div class="col-md-12">
                       <div class="small-vans">
                        <label>Company <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div> 
                    </div>

                    <div class="col-md-6">
                       <div class="small-vans">
                        <label>Email <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div> 
                    </div>

                    <div class="col-md-6">
                       <div class="small-vans">
                        <label>Telephone number<sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div> 
                    </div>
                    <div class="col-md-12">
                    <p>Notifications</p>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Booking confirmation
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Booking Updated
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Booking cancellation
                     </div>
                    </div>

                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> En route to pickup
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> 1 mile to pickup
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Arrived at pickup
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> POB notifications by email
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Dropoff 1 mile
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> Arrived at dropoff
                     </div>
                    </div>
                    <div class="col-md-4">
                        <div class="booking">
                         <input type='checkbox' name="" id=""> POD notifications by email
                     </div>
                    </div>

                    <div class="col-md-12">
                        <div class="booking">
                         <h2>Collection Address</h2>
                     </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Company <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-vans">
                        <label>First Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-vans">
                        <label>Last Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Contact Telephone  <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Address line 1 <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Address line 2 <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>City  <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Postcode  <sup>*</sup></label>
                        <input type="text" name="" id="" placeholder="" disabled>
                       </div>
                    </div>



                    <div class="col-md-12">
                        <div class="booking">
                         <h2>Delivery Address</h2>
                     </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Company <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-vans">
                        <label>First Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-vans">
                        <label>Last Name <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Contact Telephone  <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Address line 1 <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Address line 2 <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>City  <sup>*</sup></label>
                        <input type="text" name="" id="">
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Postcode  <sup>*</sup></label>
                        <input type="text" name="" id="" placeholder="" disabled>
                       </div>
                    </div>

                    <div class="col-md-12">
                        <div class="booking">
                         <h2>Notes</h2>
                         <p>Please provide details such as dimensions, weight, loading notes etc.</p>
                     </div>
                    </div>

                    <div class="col-md-12">
                        <div class="small-vans">
                        <label>Postcode  <sup>*</sup></label>
                        <input type="text" name="" id="" placeholder="Any additional details to help your delivery driver...." disabled>
                       </div>
                    </div>

                    <div class="col-md-12">
                        <div class="small-vans">
                        <input type="checkbox" name=""> I have read and accepted the T&Cs <sup>*</sup>
                       </div>
                    </div>
                     <div class="col-md-12">
                        <div class="small-vans">
                        <input type="checkbox" name=""> I have read and agree to the loading notice below <sup>*</sup>
                       </div>
                    </div>

                    <div class="col-md-12">
                        <div class="small-vans" id="small-vans">
                        <input type="checkbox" name="" id=""> <b>Would you like a return journey?</b> Check the box to add a return journey to your booking.
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans" id="small-vans">
                        <input type="checkbox" name="" id=""> <b>Sign Up To Newsletters?</b> We ocassionally send out newsletters including promotions, if you would like to receive these check the box to opt in.
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans" id="payment">
                        Payment Details <img src="images/payment.svg">
                       </div>
                    </div>

                    <div class="col-md-12">
                        <div class="small-vans" id="payment">
                        <h2>£370.80 <sup>(inc VAT)</sup></h2>
                       </div>
                    </div>
                    <div class="col-md-12">
                        <div class="small-vans" id="payment">
                        <button>Book Now</button>
                       </div>
                    </div>

                </div>
            </form>

            </div>

            <div class="col-md-4">
                <div class="collection">
                    <h6>Collection</h6>
                    <p>Between 13:50 - 14:50</p>
                    <p>Thursday 05 Jun 2025</p>
                    <p>EH48 3HU</p>

                    <h6>Delivery</h6>
                    <p>ASAP</p>
                    <p>Thursday 05 Jun 2025</p>
                    <p>B24 8HZ</p>
                </div>

                <div class="vans">
                    <img src="images/van.jpg">
                    <h2>Small Van</h2>
                    <hr>
                    <h5>Length<span>1.5m</span></h5>
                    <h5>Width<span>1.1m</span></h5>
                    <h5>Height<span>1.2m</span></h5>
                    <h5>Payload<span>400kg Max</span></h5>
                    <hr>
                    <h3>Price<span>£309.00</span></h3>
                    <h3>VAT<span>£61.80</span></h3>
                    <h3>TOTAL<span>1.2m</span></h3>
                    <h6><a href='quote-details.php' target="_blank">Change Vehicle</a></h6>
                </div>

                <div class="collection">
                    <img src="images/dotss.svg">
                    <h6>Additional Stops</h6>
                    <p>Additional stops will be managed & planned once the booking is confirmed. We will call you back on the details provided to confirm these times with you.</p>
                    <p>Call: <a hrefr='tel:01462410004'>01462410004</a></p>

                </div>
                
            </div>

        </div>
    </div>
</div>
</div>



    @include('goods.include.footer')
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js"></script> 
 <script>
        var today, datepicker;
        today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        datepicker = $('#datepicker').datepicker({
            minDate: today,
            format: 'yyyy-mm-dd'
        });
    </script>

    <script>

document.querySelector("input[type='time']").addEventListener("input", function() {
  const reTime = /^([0-1][0-9]|2[0-3]):[0-5][0-9]$/;
  if (reTime.exec(this.value)) {
    const minute = Number(this.value.substring(3,5));
    const hour = Number(this.value.substring(0,2)) % 12 + (minute / 60);
    this.style.backgroundImage = `url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'><circle cx='20' cy='20' r='18.5' fill='none' stroke='%23222' stroke-width='3' /><path d='M20,4 20,8 M4,20 8,20 M36,20 32,20 M20,36 20,32' stroke='%23bbb' stroke-width='1' /><g fill='%23222' stroke='%23222' stroke-width='2'><circle cx='20' cy='20' r='2' /><path d='M20,24 20,5' style='transform:rotate(${360 * minute / 60}deg); transform-origin: 50% 50%;' /><path d='M20,24 20,8' style='transform:rotate(${360 * hour / 12}deg); transform-origin: 50% 50%;' /></g></svg>")`;
  }
});

</script>

<script>
const progress = document.getElementById("progress");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const circles = document.querySelectorAll(".circle");

let currentActive = 1;

next.addEventListener("click", () => {
  currentActive++;
  if (currentActive > circles.length) {
    currentActive = circles.length;
  }
  update();
});

prev.addEventListener("click", () => {
  currentActive--;
  if (currentActive < 1) {
    currentActive = 1;
  }
  update();
});

function update() {
  circles.forEach((circle, index) => {
    if (index < currentActive) {
      circle.classList.add("active");
    } else {
      circle.classList.remove("active");
    }
  });
  const actives = document.querySelectorAll(".active");
  progress.style.width = `${
    ((actives.length - 1) / (circles.length - 1)) * 100
  }%`;

  if (currentActive === 1) {
    prev.disabled = true;
  } else if (currentActive === circles.length) {
    next.disabled = true;
  } else {
    prev.disabled = false;
    next.disabled = false;
  }
}

</script>


</body>
</html>