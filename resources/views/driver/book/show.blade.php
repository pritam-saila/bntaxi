@include('admin.include.sidebar')
<!-- Page Content  -->
<div class="wrapper">
   <!-- Sidebar  -->
   <!-- Page Content  -->
   <div id="content" style="padding: 20px;">
      <div class="card">
         <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Booking Details - {{$data->booking_id}}</h3>
            <a href="{{route('driver-booking.index')}}" class="btn btn-secondary btn-sm">Back</a>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                  <h5 class="text-primary border-bottom pb-2">Customer Details</h5>
                  <table class="table table-bordered">
                     <tr><th>Name</th><td>{{$data->name}}</td></tr>
                     <tr><th>Phone</th><td>{{$data->phone}}</td></tr>
                  </table>
               </div>
               <div class="col-md-6">
                  <h5 class="text-primary border-bottom pb-2">Booking Info</h5>
                  <table class="table table-bordered">
                     <tr><th>Status</th><td>{{$data->status}}</td></tr>
                     <tr><th>Price</th><td>£{{number_format($data->price, 2)}}</td></tr>
                     <tr><th>Distance</th><td>{{$data->distance}} miles</td></tr>
                  </table>
               </div>
            </div>
            
            <div class="row mt-4">
               <div class="col-md-6">
                  <h5 class="text-primary border-bottom pb-2">Journey Details</h5>
                  <table class="table table-bordered">
                     <tr><th>Pickup</th><td>{{$data->pickup}}</td></tr>
                     @if(is_array($data->distancearr) && count($data->distancearr) > 2)
                     <tr>
                         <th>Vias</th>
                         <td>
                             <ul class="mb-0 ps-3">
                             @foreach($data->distancearr as $index => $via)
                                 @if($index > 0 && $index < count($data->distancearr) - 1)
                                     <li>{{ $via }}</li>
                                 @endif
                             @endforeach
                             </ul>
                         </td>
                     </tr>
                     @endif
                     <tr><th>Dropoff</th><td>{{$data->dropoff}}</td></tr>
                     <tr><th>Pickup Date & Time</th><td>{{$data->pickup_date}} {{$data->pickup_time}}</td></tr>
                  </table>
               </div>
               <div class="col-md-6">
                  <h5 class="text-primary border-bottom pb-2">Action</h5>
                  <div class="d-flex justify-content-between mt-4">
                      <form action="{{route('driver-booking.update', $data->id)}}" method="POST" style="width: 48%;">
                          @method('PATCH')
                          @csrf
                          <input type="hidden" name="driver_status" value="Accepted">
                          <button type="submit" class="btn btn-success btn-lg w-100">Accept</button>
                      </form>
                      <form action="{{route('driver-booking.update', $data->id)}}" method="POST" style="width: 48%;">
                          @method('PATCH')
                          @csrf
                          <input type="hidden" name="driver_status" value="Rejected">
                          <button type="submit" class="btn btn-danger btn-lg w-100">Reject</button>
                      </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>