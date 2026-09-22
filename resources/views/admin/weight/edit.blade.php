
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admweight.update',$data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                  <div class="row">
                        <div class="col-md-6">
                           <label>Start</label>
                           <input type="text" class="form-control" value="{{$data->start}}" name="start" placeholder="Enter start" required="">
                        </div>
                        <div class="col-md-6">
                           <label>End</label>
                           <input type="text" class="form-control" value="{{$data->end}}" name="end" placeholder="Enter end" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Price</label>
                           <input type="text" class="form-control" value="{{$data->price}}" name="price" placeholder="Enter price" required="">
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
