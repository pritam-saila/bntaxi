
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
             <form action="{{route('admbook.store')}}" method="POST">
                @csrf
                <div class="col-12">
                     <div class="row">
                        <div class="col-md-6">
                           <label>Customer Name</label>
                           <input type="text" class="form-control" name="name" placeholder="Enter customer name" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Email</label>
                           <input type="email" class="form-control" name="email" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Phone</label>
                           <input type="text" class="form-control" name="phone" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Pickup Location</label>
                           <input type="text" class="form-control" name="pickup" required="">
                        </div>
                        <div class="col-md-6">
                           <label>Dropoff Location</label>
                           <input type="text" class="form-control" name="dropoff" required="">
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
