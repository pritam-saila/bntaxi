
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admin.routehandles.update',$data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                     <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" value="{{$data->slug}}" name="slug" placeholder="Enter slug" required="">
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" value="{{$data->title}}" name="title" placeholder="Enter title" required="">
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Subtitle</label>
                        <input type="text" class="form-control" value="{{$data->subtitle}}" name="subtitle" placeholder="Enter subtitle">
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Side</label>
                        <select class="form-control" name="side" required="">
                           <option value="sideby" {{$data->side == 'sideby' ? 'selected' : ''}}>Side By</option>
                           <option value="top" {{$data->side == 'top' ? 'selected' : ''}}>Top</option>
                        </select>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Meta Tag</label>
                        <input type="text" class="form-control" value="{{$data->metatag}}" name="metatag" placeholder="Enter metatag">
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" value="{{$data->metatitle}}" name="metatitle" placeholder="Enter metatitle">
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Meta Description</label>
                        <input type="text" class="form-control" value="{{$data->metadescription}}" name="metadescription" placeholder="Enter metadescription">
                     </div>

                 <div class="col-md-12 form-group">
                    <label>Image &nbsp;<a href="{{url(Storage::url($data->image))}}">(image view)</a></label>
                        <input type="file" class="form-control" value="" name="image">
                     </div>

                     <div class="col-md-12 form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter description" required="">{{$data->description}}</textarea>
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
