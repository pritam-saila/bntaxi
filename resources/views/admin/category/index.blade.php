
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
             <a class="btn btn-danger" href='{{route("admcategory.create")}}'>Add New Category</a>

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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                            <a class="btn btn-info" href="{{route('admcategory.subcategory.index',$item->id)}}">{{$item->title}}</a>
                            </td>
                            <td class="action">
                                    <a class="btn btn-info" href="{{route('admcategory.edit',$item->id)}}"><i class="fas fa-edit"></i></a>
                               
                                <form action="{{ route('admcategory.destroy', $item->id) }}" method="POST" style="display: contents;">
                                    @csrf
                                    @method('delete')
                                <button type="submit" class="btn btn-warning" onclick="return condelete()"><i class="fas fa-trash"></i></button>
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

