
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admblog.update',$data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                     <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" value="{{$data->title}}" name="title" placeholder="Enter name" required="">
                     </div>

                     <div class="col-md-6 form-group">
                        <label>Slug</label>
                        <input type="text" class="form-control" value="{{$data->slug}}" name="slug" placeholder="Enter slug" required="">
                     </div>

                     <div class="col-md-6">
                           <label>Date</label>
                           <input type="date" class="form-control" value="{{$data->date}}" name="date" placeholder="Enter date" required="">
                        </div>

                 <div class="col-md-6 form-group">
                    <label>Image &nbsp;<a href="{{url(Storage::url($data->image))}}">(image view)</a></label>
                        <input type="file" class="form-control" value="" name="image">
                     </div>

                     <div class="col-md-12 form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter description" required="">{{$data->description}}</textarea>
                     </div>

                     <div class="col-md-12">
                        <h5 class="mt-3">SEO Section</h5>
                     </div>
                     <div class="col-md-6">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" value="{{$data->metatitle}}" name="metatitle" placeholder="Enter Meta Title">
                     </div>
                     <div class="col-md-6">
                        <label>Meta Keywords</label>
                        <input type="text" class="form-control" value="{{$data->metatag}}" name="metatag" placeholder="Enter Meta Keywords">
                     </div>
                     <div class="col-md-12">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="metadescription" placeholder="Enter Meta Description">{{$data->metadescription}}</textarea>
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
