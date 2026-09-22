
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content" style="padding: 20px;">
          <div class="card">
             <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Respond to Ride - {{$data->booking_id}}</h3>
                <a href="{{route('driver-booking.index')}}" class="btn btn-secondary btn-sm">Back</a>
             </div>
             <div class="card-body text-center">
                <h4 class="mb-4">Do you want to accept or reject this ride?</h4>
                <p><strong>From:</strong> {{$data->pickup}}</p>
                @if(is_array($data->distancearr) && count($data->distancearr) > 2)
                <p><strong>Vias:</strong> 
                    @foreach($data->distancearr as $index => $via)
                        @if($index > 0 && $index < count($data->distancearr) - 1)
                            {{ $via }}@if($index < count($data->distancearr) - 2), @endif
                        @endif
                    @endforeach
                </p>
                @endif
                <p><strong>To:</strong> {{$data->dropoff}}</p>
                <p><strong>Price:</strong> £{{number_format($data->price, 2)}}</p>
                
                <form action="{{route('driver-booking.update', $data->id)}}" method="POST" style="display:inline-block;">
                   @method('PATCH')
                   @csrf
                   <input type="hidden" name="driver_status" value="Accepted">
                   <button type="submit" class="btn btn-success btn-lg mt-3">Accept Ride</button>
                </form>
                <form action="{{route('driver-booking.update', $data->id)}}" method="POST" style="display:inline-block;">
                   @method('PATCH')
                   @csrf
                   <input type="hidden" name="driver_status" value="Rejected">
                   <button type="submit" class="btn btn-danger btn-lg mt-3">Reject Ride</button>
                </form>
             </div>
          </div>
       </div>
    </div>
