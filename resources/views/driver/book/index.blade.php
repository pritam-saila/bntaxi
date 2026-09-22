
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
             <!-- <a class="btn btn-danger" href='{{route("admbanner.create")}}'>Add New Banner</a> -->

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
                            <th>Order</th>
                            <th>Date</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$item->booking_id}}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>{{$item->pickup}}</td>
                            <td>{{$item->dropoff}}</td>
                            <td>£{{number_format($item->price, 2)}}</td>
                            <td>{{$item->status}}</td>
                            <td>
                                <a href="{{route('driver-booking.show', $item->id)}}" class="btn btn-info btn-sm">Show</a>
                                <form action="{{route('driver-booking.update', $item->id)}}" method="POST" style="display:inline-block;">
                                @method('PATCH')
                                @csrf
                                    <input type="hidden" name="driver_status" value="Accepted">
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>
                                <form action="{{route('driver-booking.update', $item->id)}}" method="POST" style="display:inline-block;">
                                @method('PATCH')
                                @csrf
                                    <input type="hidden" name="driver_status" value="Rejected">
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
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
