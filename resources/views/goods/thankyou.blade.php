<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	@include('goods.include.assets')
	<title>Thank You</title>

<style>
    .thankyou-wrapper{
      width:100%;
      height:100vh;
      margin:auto;
      background:#ffffff; 
      padding:10px 0px 50px;
    }
    .thankyou-wrapper h1{
      font:100px Arial, Helvetica, sans-serif;
      text-align:center;
      color:#333333;
      padding:0px 10px 10px;
    }
    .thankyou-wrapper p{
      font:26px Arial, Helvetica, sans-serif;
      text-align:center;
      color:#333333;
      padding:5px 10px 10px;
    }
    .thankyou-wrapper a{
      font:26px Arial, Helvetica, sans-serif;
      text-align:center;
      color:#ffffff;
      display:block;
      text-decoration:none;
      width:250px;
      background:#E47425;
      margin:10px auto 0px;
      padding:15px 20px 15px;
      border-bottom:5px solid #F96700;
    }
    .thankyou-wrapper a:hover{
      font:26px Arial, Helvetica, sans-serif;
      text-align:center;
      color:#ffffff;
      display:block;
      text-decoration:none;
      width:250px;
      background:#F96700;
      margin:10px auto 0px;
      padding:15px 20px 15px;
      border-bottom:5px solid #F96700;
    }
</style>

</head>
<body>
  @include('goods.include.header')


<section class="login-main-wrapper">
      <div class="main-container">
          <div class="login-process">
              <div class="login-main-container">
                  <div class="thankyou-wrapper">
                      <h1><img src="{{url('images/thankyou.png')}}" alt="thanks" /></h1>
                        <p>Thank you For your booking </p>
                        <a href="{{url('/user-account')}}">Order View</a>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
    </section>

	@include('goods.include.footer')

	

</body>
</html>