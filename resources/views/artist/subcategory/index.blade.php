
    @include('artist.include.sidebar')
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
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        
                        <tr>
                        <form action="{{route('artcategory.artsubcategory.store',$item->id)}}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="subcat_id" value="{{$item->cat_id}}">
                        @csrf
                            <td>{{$loop->iteration}}</td>
                            <td>
                            {{$item->title}}
                            </td>
                            <td><input type="number" class="form-control" id="" name="price" placeholder="Enter Price" value="{{$item->price}}" required=""></td>
                            <td>
                            <input type="submit" class="btn btn-success" value="submit">
                            </td>
                            </form>
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

