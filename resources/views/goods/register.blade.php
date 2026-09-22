<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BN Taxi Anytime</title>
    
  @include('goods.include.assets')


  
</head>
<body>
  @include('goods.include.header')

  

  <div class="banners">
            <div class="banner-paras">
            <h1>Register</h1>
            <h5>Home // <a href=""> Register</a> </h5>
            
          </div>
  </div>

  <div class="banner_bottom">
    <div class="container">
        <h2>Get a FREE Instant Quote Here <span>Get A Quote</span></h2>
    </div>
    </div>

    <main class="main pages">
        
        <div class="page-content pt-50 pb-50">
            <div class="container">
                <div class="row">   
                            <div class="col-md-12">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                        <h1 class="mb-5">Create an Account</h1>
                                        @if(session()->has('success'))
                                        <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">
                                        {{ session()->get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        @if(session()->has('error'))
                                        <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">
                                        {{ session()->get('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <p class="mb-30">Already have an account? <a href="{{url('/user-login')}}">Login</a></p>
                                        <form method="POST" action="{{url('/postregister')}}">
                                            @csrf
                                            <input type="hidden" name="type" value="0">
                                            <div class="form-group">
                                                <input type="text" name="name" placeholder="Username" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" placeholder="Email" autocomplete="off" required="">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" placeholder="Password" autocomplete="off" required="">
                                            </div>
                                            
                                            <div class="login_footer form-group mb-50">
                                                <div class="chek-form">
                                                    <div class="custome-checkbox">
                                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" required="">
                                                        <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="form-group mb-30" id="registers">
                                                <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="login">Submit &amp; Register</button>
                                            </div>
                                            <p class="font-xs text-muted"><strong>Note:</strong>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy</p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
    </main>

  

    @include('goods.include.footer')

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script>



</body>
</html>