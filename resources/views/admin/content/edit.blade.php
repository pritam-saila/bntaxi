
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admcontent.update',$data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                     <div class="row">
                     <div class="col-md-6">
                           <label>heading</label>
                           <input type="text" class="form-control" id="" name="heading" placeholder="Enter name" value="{{$data->heading}}">
                        </div>
                        <div class="col-md-6">
                           <label>title</label>
                           <input type="text" class="form-control" id="" name="title" placeholder="Enter name" value="{{$data->title}}" required="">
                        </div>
                        <div class="col-md-6">
                           <label>menu</label>
                           <input type="text" class="form-control" id="" name="menu" placeholder="Enter menu" value="{{$data->menu}}" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Image @if ($data->image)
                              <a href="{{url(Storage::url($data->image))}}">(view)</a>
                           @endif</label>
                           <input type="file" class="form-control" id="" name="image">
                        </div>
                        <div class="col-md-6">
                           <label>meta_description</label>
                           <input type="text" class="form-control" id="" name="meta_description" value="{{$data->meta_description}}" placeholder="Enter meta_description" required="">
                        </div>

                        <div class="col-md-6">
                           <label>meta_keyword</label>
                           <input type="text" class="form-control" id="" name="meta_keyword" placeholder="Enter meta_keyword" value="{{$data->meta_keyword}}" required="">
                        </div>
                        <div class="col-md-6">
                           <label>canonicalcode</label>
                           <input type="text" class="form-control" id="" name="canonicalcode" placeholder="Enter canonicalcode" value="{{$data->canonicalcode}}" required="">
                        </div>

                     <div class="col-md-12 form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter description" required="">{!! $data->description !!}</textarea>
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
