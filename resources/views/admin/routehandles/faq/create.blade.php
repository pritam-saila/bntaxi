
    @include('admin.include.sidebar')

    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">
          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admin.routehandles.faq.store', $routehandle->id)}}" method="POST">
                @csrf
                <div class="col-12">
                     <div class="row">
                        <div class="col-md-12 form-group">
                           <label>Question</label>
                           <input type="text" class="form-control" name="question" placeholder="Enter question">
                        </div>
                        <div class="col-md-12 form-group mt-2">
                           <label>Answer</label>
                           <textarea class="form-control" name="answer" placeholder="Enter answer" rows="5"></textarea>
                        </div>
                        <div class="col-md-12 mt-2">
                           <input type="submit" class="btn btn-success" value="submit">
                           <a href="{{ route('admin.routehandles.faq.index', $routehandle->id) }}" class="btn btn-secondary">Back</a>
                        </div>
                     </div>
                </div>
             </form>
          </div>
       </div>
    </div>
