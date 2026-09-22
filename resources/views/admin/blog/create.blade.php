
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
             <form action="{{route('admblog.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                     <div class="row">
                        <div class="col-md-6">
                           <label>Name</label>
                           <input type="text" class="form-control" id="" name="title" placeholder="Enter name" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Date</label>
                           <input type="date" class="form-control" id="" name="date" placeholder="Enter designation" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Image</label>
                           <input type="file" class="form-control" id="" name="image" required="">
                        </div>
                        <div class="col-md-12">
                           <label>Description</label>
                           <textarea class="form-control" id="" name="description" placeholder="Enter description"></textarea>
                        </div>
                        <div class="col-md-12">
                           <h5 class="mt-3">SEO Section</h5>
                        </div>
                        <div class="col-md-6">
                           <label>Meta Title</label>
                           <input type="text" class="form-control" name="metatitle" placeholder="Enter Meta Title">
                        </div>
                        <div class="col-md-6">
                           <label>Meta Keywords</label>
                           <input type="text" class="form-control" name="metatag" placeholder="Enter Meta Keywords">
                        </div>
                        <div class="col-md-12">
                           <label>Meta Description</label>
                           <textarea class="form-control" name="metadescription" placeholder="Enter Meta Description"></textarea>
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
