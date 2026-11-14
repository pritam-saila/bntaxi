<!DOCTYPE html>
<html lang="en-GB">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>BN Taxi Anytime</title>

        @include('goods.include.assets')
    </head>
    <body>
        @include('goods.include.header')

        <div class="banners">
            <div class="banner-paras">
                <h1>Pallet Delivery Service</h1>
                <h5>Home // <a href=""> Pallet Delivery Service</a></h5>
            </div>
        </div>

        <div class="banner_bottom">
            <div class="container">
                <h2>Get a FREE Instant Quote Here <span>Get A Quote</span></h2>
            </div>
        </div>

        <div class="contain_para">
            <div class="container">
                <h2>Effortless Pallet Delivery Service: fast, reliable, and trackable across the UK and beyond.</h2>
                <p>
                    Are you looking for a reliable pallet delivery partner? Look no further than HBC Logistics! Our comprehensive pallet delivery service in Bedfordshire offers instant quotes, same-day collection and real-time tracking,
                    ensuring your goods are delivered safely and swiftly. Our expertise enables us to deliver anywhere in the UK within twenty-four hours, because convenience is an utmost priority for us.
                </p>
                <p>
                    Whether your dealing with time-sensitive deliveries or large, regular and complex loads, you can trust HBC Logistics to handle your pallet deliveries with ease – backed by our PLATINUM-earned service and several awards
                    achieved over the years.
                </p>

                <h3>Key Benefits include:</h3>
                <ul>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Accurate and fast delivery quotes with great value for money</li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Carbon Neutral pallet delivered</li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Convenient and flexible delivery times – same day collection</li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Able to ship to Ireland & Mainland Europe</li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> First-class technology used to provide live ETAs and pictures on PODs</li>
                    <li><i class="fa fa-angle-double-right" aria-hidden="true"></i> Members of leading Pallet Networks</li>
                </ul>

                <img src="{{url('goods')}}/images/pallect.jpg" />

                <h3>Contact Us Today For a Free Quote</h3>
                <p>Complete the details below and we will be in touch. Please note you will need to fill in all details correctly in order to be contacted.</p>

                <div class="collecting">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Where do you need collecting from? <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Postcode" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Where are we delivering to? <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Postcode" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Pallet Size Options<sup>*</sup></label>
                                <select>
                                    <option value="" id="">What size pallets do you need transporting?</option>
                                    <option value="" id="">Quarter Plus: 1.2m x 1.2m x 1.1m (400kg max.)</option>
                                    <option value="" id="">Quarter Plus: 1.2m x 1.2m x 1.1m (400kg max.)</option>
                                    <option value="" id="">Quarter Plus: 1.2m x 1.2m x 1.1m (400kg max.)</option>
                                    <option value="" id="">Quarter Plus: 1.2m x 1.2m x 1.1m (400kg max.)</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>How often do you ship pallets? <sup>*</sup></label>
                                <select>
                                    <option value="" id="">How often do you ship pallets?</option>
                                    <option value="" id="">Every day</option>
                                    <option value="" id="">Every Week</option>
                                    <option value="" id="">Every Month</option>
                                    <option value="" id="">Monthly/Bi-Monthly</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Contact Name <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Name" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Company Name <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Company" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Contact Email <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Email" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="collecting_form">
                                <label>Contact Number <sup>*</sup></label>
                                <input type="text" name="" id="" placeholder="Number" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="collecting_form">
                                <input type="submit" value="Send Message" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('goods.include.footer')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>
    </body>
</html>
