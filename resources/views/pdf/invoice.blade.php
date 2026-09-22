<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Pdf</title>
      <style>
         table {
         font-family: arial, sans-serif;
         border-collapse: collapse;
         width: 100%;
         }
         td, th {
         border: 1px solid #dddddd;
         text-align: left;
         padding: 8px;
         }
         tr:nth-child(even) {
         background-color: #dddddd;
         }
         .chart{
         width: 70%;
         margin: 20px auto;
         }
         .chart h2{
         font-size: 20px;
         margin-bottom: 20px;
         font-weight: bold;
         }
         .chart h1{
         text-align: center;
         font-weight: bold;
         font-size: 24px;
         }
         .chat1 h3{
         font-size: 20px;
         font-weight: bold;
         }
         .chat1 h4{
         font-size: 20px;
         font-weight: bold;
         }
         .chat1 p{
         text-align: right;
         margin: 0;
         padding: 10px 0;
         }
         .chat1 h6{
         margin: 0;
         padding: 10px 0;
         }
      </style>
   </head>
   <body>
   @php 
        $packagedetails = unserialize($book['bookedarr']);
    @endphp
      <div class="chart">
         <h1>Invoice</h1>
         <div class="chat1">
            <h3>{{env('APP_NAME')}}</h3>
            <h4>+44 0203 13321</h4>
            <h6>{{$book['name']}} , {{$book['email']}}</h6>
            <h6>Phone {{$book['phone']}}</h6>
            <h6><span>Distance - <?= $packagedetails->distance; ?> Mile</span></h6>
            <h2>Booking ID:<span>{{$book['booking_id']}}</span></h2>
         </div>
         <table>
            <thead>
                <tr>
                    <th>Delivery details</th>
                    <th>Dimention</th>
                    <th>Price</th>
                    <th>Pick Up</th>
                    <th>Drop</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <td>
                            
                    @for ($i = 0; $i < count($packagedetails->distancearr); $i++)
                    <p><span>@if($i == 0) From @elseif($i == count($packagedetails->distancearr) - 1) To @else Via @endif -</span> <?= $packagedetails->distancearr[$i]; ?> - {{$packagedetails->typeofdel[$i]}}</p>
                    @endfor
                    <p><span>Distance - <?= $packagedetails->distance; ?> Mile</span></p>
                    </td>
                    <td>length - <?= $packagedetails->length; ?> cm, Height - <?= $packagedetails->height; ?> cm, width - <?= $packagedetails->width; ?> cm</td>
                    <td>
                    £ {{$book['price']}}
                    </td>
                    <td>
                    <?php 
                    echo $packagedetails->date.' '.$packagedetails->formtime1.'-'.$packagedetails->todate1.' '.$packagedetails->totime1;?>
                    </td>
                    <td>
                    <?php 
                    $packagedetails->dropdate = date('F d, Y', strtotime($packagedetails->dropdate));
                    echo $packagedetails->dropdate.' '.$packagedetails->droptime1.'-'.$packagedetails->dropdateto.' '.$packagedetails->droptime2;?>
                    </td>
                </tr>
            </tbody>
         </table>
         <hr>

         @if($book['addonssoft'])
         <table>
            <h2>Add on</h2>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
            @php
                $price = 0;
            @endphp
            @foreach($book['addonssoft'] as $itemlist)
                @if($itemlist[0])
                    @php
                        $price = $price + $itemlist[1];
                    @endphp
                <tr>
                <th>{{$itemlist[0]}}</th>
                <th>£ {{$itemlist[1]}}</th>
                </tr>
                @endif
            @endforeach
            <tr>
               <th>Add On Total</th>
               <th>£ {{$price}}</th>
            </tr>
            </tbody>
         </table>
         @endif

        <table>
         <tr>
               <th>Total Price</th>
               <th>£ {{$price + $book['price']}}</th>
            </tr>
        </table>
      </div>
   </body>
</html>