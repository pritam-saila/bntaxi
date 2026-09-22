
    @include('admin.include.sidebar')

    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">
         @if(session()->has('success'))
         <div class="alert alert-success mb-2 alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         @endif
         @if(session()->has('error'))
         <div class="alert alert-danger mb-2 alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         @endif
          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admin.routehandles.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                     <div class="row">
                        <div class="col-md-6 form-group">
                           <label>Slug</label>
                           <input type="text" class="form-control" id="" name="slug" placeholder="Enter slug" required="">
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Title</label>
                           <input type="text" class="form-control" id="" name="title" placeholder="Enter title" required="">
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Subtitle</label>
                           <input type="text" class="form-control" id="" name="subtitle" placeholder="Enter subtitle">
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Side</label>
                           <select class="form-control" name="side" required="">
                              <option value="sideby">Side By</option>
                              <option value="top">Top</option>
                           </select>
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Meta Tag</label>
                           <input type="text" class="form-control" id="" name="metatag" placeholder="Enter metatag">
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Meta Title</label>
                           <input type="text" class="form-control" id="" name="metatitle" placeholder="Enter metatitle">
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Meta Description</label>
                           <input type="text" class="form-control" id="" name="metadescription" placeholder="Enter metadescription">
                        </div>
                        <div class="col-md-12 form-group mt-2">
                           <label>Image</label>
                           <input type="file" class="form-control" id="" name="image" required="">
                        </div>
                        <div class="col-md-12 form-group mt-2">
                           <label>Description</label>
                           <textarea class="form-control" id="" name="description" placeholder="Enter description"></textarea>
                        </div>
                        <div class="col-md-12 mt-2">
                           <input type="submit" class="btn btn-success" value="submit">
                        </div>
                     </div>
                </div>
             </form>
          </div>
       </div>
    </div>
