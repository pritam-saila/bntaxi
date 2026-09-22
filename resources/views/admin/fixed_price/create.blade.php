@include('admin.include.sidebar')

<div class="wrapper">
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
            <form action="/admfixedprice" method="POST">
                @csrf
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Car Type</label>
                            <select class="form-control" name="car_id" required>
                                <option value="">Select Car</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Destination Name</label>
                            <input type="text" class="form-control" name="destination_name" placeholder="e.g. Gatwick Airport" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Dropoff Price (£)</label>
                            <input type="number" step="0.01" class="form-control" name="drop_price" placeholder="e.g. 85.00" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Pickup / Return Price (£)</label>
                            <input type="number" step="0.01" class="form-control" name="pickup_price" placeholder="e.g. 95.00" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Keywords (comma-separated, for matching addresses)</label>
                            <input type="text" class="form-control" name="keywords" placeholder="e.g. gatwick, gatwick airport" required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <input type="submit" class="btn btn-success" value="Submit">
                            <a href="/admfixedprice" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
