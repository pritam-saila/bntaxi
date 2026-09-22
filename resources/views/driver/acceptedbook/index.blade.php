
    @include('admin.include.sidebar')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-danger">
                <i class="fas fa-align-left"></i>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>
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

        </div>
    </nav>

        <!-- Page Content  -->
    <div class="wrapper">
        <!-- Sidebar  -->


        <!-- Page Content  -->
        <div id="content" style="padding: 20px 0;">
            <div class="navbar-expand-lg navbar-light bg-light">
                <table id="example" class="table table-striped table-bordered dark" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Distance</th>
                            <th>Price</th>
                            <th>Pickup Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->pickup}}</td>
                            <td>{{$item->dropoff}}</td>
                            <td>{{$item->distance}} Miles</td>
                            <td>£{{$item->price}}</td>
                            <td>{{$item->pickup_date}} {{$item->pickup_time}}</td>
                            <td>
                            <form action="{{route('driver-accepted-booking.update',$item->id)}}" method="POST" enctype="multipart/form-data"style="display: contents;">
                                @method('PATCH')
                                @csrf
                                <select name="driver_status" class="form-control form-control-sm mb-2">
                                    <option value="pending" {{$item->driver_status == 'pending' ? 'selected' : ''}}>Pending</option>
                                    <option value="accepted" {{$item->driver_status == 'accepted' ? 'selected' : ''}}>Accepted</option>
                                    <option value="on_route_to_collection" {{$item->driver_status == 'on_route_to_collection' ? 'selected' : ''}}>On route to collection</option>
                                    <option value="at_collection_point" {{$item->driver_status == 'at_collection_point' ? 'selected' : ''}}>At Collection Point</option>
                                    <option value="collected" {{$item->driver_status == 'collected' ? 'selected' : ''}}>Collected</option>
                                    <option value="on_route_to_delivery" {{$item->driver_status == 'on_route_to_delivery' ? 'selected' : ''}}>On route to Delivery</option>
                                    <option value="at_delivery_point" {{$item->driver_status == 'at_delivery_point' ? 'selected' : ''}}>At Delivery Point</option>
                                    <option value="delivered" {{$item->driver_status == 'delivered' ? 'selected' : ''}}>Delivered</option>
                                </select>
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                            </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

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
