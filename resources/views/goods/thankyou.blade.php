<!DOCTYPE html>
<html lang="en-GB">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	@include('goods.include.assets')
	<title>Thank You</title>

@stylesheet('goods/css/pages/thankyou.css')

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