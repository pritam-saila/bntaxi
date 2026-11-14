<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BN Taxi Anytime</title>

    
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet">
     
  @include('goods.include.assets')


<style>
.pickups{
    display: flex;
    align-items: center;
    justify-content: center;
}
.pickups i{
    font-size:15px;
    font-weight: bold;
    width:17%;
    color: #267fca;

}
.pickups h4{
    font-size: 14px;
    font-weight: 400;
    display: grid;
    line-height: 20px;
    color: #fff;
}
.pickups span{
    font-weight: bold;
}
#pickups{
    background:#101d3b;
    margin: 25px 0;
    padding: 15px 0;
    border-radius: 5px;
}
.quots{
    display: flex;
    align-items: center;
    justify-content: center;
}
.quots i{
    color: #267fca;
}
.quots h6{
    color: #fff;
    margin: 0;
    line-height: 42px;
}


/*datepicker////////*/
.dates{
    width: 100%;
}
.collection h2{
    font-size: 15px;
    font-weight: bold;
}


.vans{
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    padding: 15px;
    margin-bottom: 20px;
}
.vans h2{
    font-weight: bold;
    font-size: 20px;
    text-align: center;
}
.vans h5{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    font-weight: 400;
    line-height: 25px;
}

.vans h3{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 15px;
    font-weight: 600;
    line-height: 25px;
}
.vans img{
    width:100%;
}
.vans h6{
    font-weight: bold;
    color: #fff;
}
.vans h6 a{
    background: #101d3b;
    width: 100%;
    display: block;
    /* margin: 10px; */
    text-align: center;
    padding: 8px;
    color: #fff;
    border-radius: 10px;
    width: 80%;
    margin: 20px auto 0 auto;
}



.dates input[type="time"] {
  padding-left: 1.5em;
  background-repeat: no-repeat;
  background-position: 0.25em center;
  background-size: 1em;
  background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='40' height='40'><circle cx='20' cy='20' r='18.5' fill='none' stroke='%23222' stroke-width='3' /><path d='M20,4 20,8 M4,20 8,20 M36,20 32,20 M20,36 20,32' stroke='%23bbb' stroke-width='1' /><g fill='%23222' stroke='%23222' stroke-width='2'><circle cx='20' cy='20' r='2' /><path d='M20,24 20,5' style='transform:rotate(120deg); transform-origin: 50% 50%;' /><path d='M20,24 20,8' style='transform:rotate(20deg); transform-origin: 50% 50%;' /></g></svg>");
  /* this style to complete the styling*/
  border: 0.125em solid #369;
  border-radius: 0.25em;
  font-size: 1rem;
}

#coocolor{
    background: #f1f1f1;
    padding: 10px 0;
}
.collection{
    margin: 30px 0;
}


</style>



<style type="text/css">
.progress-container {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
  max-width: 100%;
  width: 350px;
  position: relative
}

.progress-container::before {
  content: "";
  background-color: #e0e0e0;
  position: absolute;
  top: 50%;
  left: 0;
  height: 4px;
  width: 100%;
  transform: translateY(-50%);
  z-index: -1;
}

.progress {
  background-color: #3498db;
  position: absolute;
  top: 50%;
  left: 0;
  height: 4px;
  width: 0%;
  transform: translateY(-50%);
  z-index: -1;
  transition: .4s ease;
}

.circle {
  background-color: white;
  color: #999;
  border-radius: 50%;
  height: 30px;
  width: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 3px solid #e0e0e0;
  transition: .4s ease;
}

.circle.active {
  border-color: #3498db;
}

.btn {
  background-color: #3498db;
  color: #fff;
  border: 0;
  border-radius: 6px;
  cursor: pointer;
  font-family: inherit;
  padding: 8px 30px;
  margin: 5px;
  font-size: 14px;
}

.btn:active {
  transform: scale(.98);
}

.btn:focus {
  outline: 0;
}

.btn:disabled {
  background-color: #e0e0e0;
  cursor: not-allowed;
}









.progreess{

}
.progress-container{
    text-align: center;
    margin: 0 auto;
}
.progreess{
           width: 45%;
    margin: 0 auto;
    text-align: center;
/*    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;*/
    padding: 30px 0 0 0;
    position: absolute;
    bottom: 170px;
    left: 27%;
    background-color: #fff;
    z-index: 11111;
    border-radius: 10px;

}

.circle p{
    margin-top: 60px;
    font-weight: bold;
}
.progreess button{
    margin: 40px 0;
}
#banners{
    position: relative;
    margin-bottom: 150px;
}





.main-forms input{
    width: 100%;
    height: 45px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    border-radius: 10px;
    padding: 0 10px;
    margin-bottom: 10px;
}
.main-forms label{
    margin: 0;
    padding: 10px 0;
}
.main-forms sup{
    color: red;
}
.main-forms p{
    margin: 10px 0;
}
.main-forms input[type='checkbox']{
    width:15px;
    height: 15px;

}
.booking{
    line-height: 35px;
}
.booking{
    color:#000;
}
.booking h2{
    font-weight: bold;
    margin: 0;
    padding: 15px 0;
    font-size: 20px;
}
#payment{
    margin: 15px 0;
}
#payment img{
    margin-left: 10px;
}
#payment button{
    background-color: #101d3b;
    border-radius: 10px;
    border:none;
    outline: none;
    color: #fff;
    padding: 6px 10px;
}
.collection h6{
    position: relative;
    color: #fff;
    font-size: 20px;
    font-weight:bold;
    margin: 20px 0;
}
.collection h6::before{
    content: "";
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 4px solid #267fca;
    display: block;
    position: absolute;
    left: -31px;
    top: 6px;
}
.collection p{
    font-size: 15px;
    line-height: 23px;
    color: #fff;
}
.collection{
    background-color:#101d3b;
    padding: 60px;
    border-radius: 15px;
}


</style>


  
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