
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('driver-accepted-booking.update', $data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                     <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="{{$data->name}}" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{$data->email}}" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pickup</label>
                            <input type="text" class="form-control" value="{{$data->pickup}}" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Dropoff</label>
                            <input type="text" class="form-control" value="{{$data->dropoff}}" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Distance</label>
                            <input type="text" class="form-control" value="{{$data->distance}} Miles" readonly>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Status</label>
                            <select name="driver_status" class="form-control">
                                <option value="pending" {{$data->driver_status == 'pending' ? 'selected' : ''}}>Pending</option>
                                <option value="accepted" {{$data->driver_status == 'accepted' ? 'selected' : ''}}>Accepted</option>
                                <option value="on_route_to_collection" {{$data->driver_status == 'on_route_to_collection' ? 'selected' : ''}}>On route to collection</option>
                                <option value="at_collection_point" {{$data->driver_status == 'at_collection_point' ? 'selected' : ''}}>At Collection Point</option>
                                <option value="collected" {{$data->driver_status == 'collected' ? 'selected' : ''}}>Collected</option>
                                <option value="on_route_to_delivery" {{$data->driver_status == 'on_route_to_delivery' ? 'selected' : ''}}>On route to Delivery</option>
                                <option value="at_delivery_point" {{$data->driver_status == 'at_delivery_point' ? 'selected' : ''}}>At Delivery Point</option>
                                <option value="delivered" {{$data->driver_status == 'delivered' ? 'selected' : ''}}>Delivered</option>
                            </select>
                        </div>
                     </div>

                      <div class="col-md-12 mt-2">
                         <input type="submit" class="btn btn-success" value="Submit">
                      </div>
                   </div>
                </div>
             </form>
          </div>
       </div>
    </div>
    
  <style>
     .trashclass{
      position: absolute;
      top: 10px;
      left: 25px;
      color: red;
     }
  </style>

  <script type="text/javascript">
        function condelete()
        {
        var message=confirm("Do you really want to delete");
        if(message==true)
        {
        return true;
        }
        else
        {
        return false;
        }
        }
        bootbox.confirm("Are you sure?", function(result) {
          Example.show("Confirm result: "+result);
        });

      </script>
