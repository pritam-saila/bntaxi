
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
             <form action="{{route('admweek.time.store',$admweek)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12">
                     <div class="row">
                        <div class="col-md-6">
                           <label>Start Time</label>
                           <input type="time" class="form-control" id="" name="start" placeholder="Enter Start Time" required="">
                        </div>

                        <div class="col-md-6">
                           <label>End time</label>
                           <input type="time" class="form-control" id="" name="end" placeholder="Enter End Time" required="">
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
